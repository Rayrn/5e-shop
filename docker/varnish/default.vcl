vcl 4.0;

import std;

backend default {
  .host = "web";
  .port = "80";
  # Health check
  #.probe = {
  #  .url = "/";
  #  .timeout = 5s;
  #  .interval = 10s;
  #  .window = 5;
  #  .threshold = 3;
  #}
}

# Hosts allowed to send BAN requests
acl invalidators {
  "localhost";
  "app";
  # local Kubernetes network
  "10.0.0.0"/8;
  "172.16.0.0"/12;
  "192.168.0.0"/16;
}

sub vcl_recv {
  unset req.http.Cookie;
  unset req.http.X-Forwarded-For;

  if (req.restarts > 0) {
    set req.hash_always_miss = true;
  }

  # Remove the "Forwarded" HTTP header if exists (security)
  unset req.http.forwarded;

  # To allow API Platform to ban by cache tags
  if (req.method == "POST") {
    if (client.ip !~ invalidators) {
      return (synth(405, "Not allowed"));
    }
    if (req.http.Surrogate-Key && req.http.Fastly-Key) {
      ban("obj.http.Surrogate-Key ~ (" + regsuball(regsuball(req.http.Surrogate-Key, "\/", "\\/"),"\s+","|") + ")");
      return (synth(200, "Ban added"));
    }
  }

  # For health checks
  if (req.method == "GET" && req.url == "/healthz") {
    return (synth(200, "OK"));
  }
}

sub vcl_hit {
  if (obj.ttl >= 0s) {
    # A pure unadulterated hit, deliver it
    return (deliver);
  }

  if (std.healthy(req.backend_hint)) {
    # The backend is healthy
    # Fetch the object from the backend
    return (restart);
  }

  # No fresh object and the backend is not healthy
  if (obj.ttl + obj.grace > 0s) {
    # Deliver graced object
    # Automatically triggers a background fetch
    return (deliver);
  }

  # No valid object to deliver
  # No healthy backend to handle request
  # Return error
  return (synth(503, "API is down"));
}

sub vcl_deliver {
  # Don't send cache tags related headers to the client
  unset resp.http.url;

  # Comment the following line to send the "Cache-Tags" header to the client (e.g. to use CloudFlare cache tags)
  unset resp.http.Cache-Tags;

  # Insert Diagnostic header to show Hit or Miss
  if (obj.hits > 0) {
    set resp.http.X-Cache = "HIT";
    set resp.http.X-Cache-Hits = obj.hits;
  }
  else {
    set resp.http.X-Cache = "MISS";
  }
}

sub vcl_backend_response {
  # Ban lurker friendly header
  set beresp.http.url = bereq.url;

  # Add a grace in case the backend is down
  set beresp.grace = 1h;
}

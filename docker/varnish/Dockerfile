FROM varnish:6.3

COPY docker/varnish/default.vcl /etc/varnish/

CMD ["varnishd", "-F", "-f", "/etc/varnish/default.vcl", "-p", "http_resp_hdr_len=131072", "-p", "http_resp_size=300288", "-p", "workspace_backend=524288"]

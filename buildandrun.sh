docker build -t icinga_dalet .
docker run -d --name graphite --restart=always -p 9090:80 -p 2003:2003 hopsoft/graphite-statsd
docker run -d --name=grafana -p 3000:3000 grafana/grafana

docker run -e HOST_PC_IP="192.168.154.128" -d -ti --name icinga_dalet -p 10103:10103 -p 9001:9001 -p 3080:80 -p 222:22 --link graphite:graphite -e ICINGA2_FEATURE_GRAPHITE=1 -e ICINGA2_FEATURE_GRAPHITE_HOST="192.168.154.128" -e ICINGA2_FEATURE_GRAPHITE_PORT=2003 icinga_dalet


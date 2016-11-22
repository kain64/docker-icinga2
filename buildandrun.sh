docker build -t icinga_dalet .
docker run  -d -ti --name icinga_dalet -p 9001:9001 -p 3080:80 -p 222:22 --link graphite:graphite -e ICINGA2_FEATURE_GRAPHITE=1 -e ICINGA2_FEATURE_GRAPHITE_HOST="192.168.154.128" -e ICINGA2_FEATURE_GRAPHITE_PORT=2003 icinga_dalet


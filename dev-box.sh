DUID=$(id -u) DGID=$(id -g) exec -a "$0" docker-compose -f .dev-box/docker-compose.yml run --name crd-box --rm php sh

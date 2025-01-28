.DEFAULT_GOAL := help

.PHONY: start
start: ## Start the php server
	docker-compose up -d

.PHONY: stop
stop: ## Stop the php server
	docker-compose down

.PHONY: rebuild
rebuild: ## Rebuild docker image
	docker-compose build
	
.PHONY: logs
logs: ## Print logs
	docker-compose logs -f

.PHONY: clean
clean: ## Clean docker environment
	docker system prune -f

.PHONY: setup
setup: ## Install dependencies
	npm install

.PHONY: live
live: ## Start live server
	browser-sync start --proxy "localhost:8080" --files "src/**/*" --no-cache

.PHONY: help
help: ## Show this help message
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

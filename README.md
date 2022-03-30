# docker-openresearch-stack

Build a local OpenResearch Stack (MediaWiki &amp; extensions) with Docker.

## Requirements

#### Docker
```
docker --version
```
https://www.docker.com/get-started

#### Docker-Compose
```
docker-compose --version
```
## Release
- Set version in `context/Dockerfile` following the [Semantic Versioning Specification](https://semver.org/):

        ARG OPENRESEARCH_STACK_VERSION=5.1.0-alpha1

- Commit your changes with comment "prepared <OPENRESEARCH_STACK_VERSION>"
- Start a new "release" in GitHub. This will
	- run the CI process,
	- build the Docker image,
	- and release the image with the correct version tagged

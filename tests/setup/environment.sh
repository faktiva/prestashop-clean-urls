#!/usr/bin/env sh

echo "Setting up defaults and values for environment variables"

export TEST_PROTO="${TEST_PROTO:=http}"
export TEST_HOST="${TEST_HOST:=localhost}"
export TEST_BASE_DIR="${TEST_BASE_DIR:=/}"

export TEST_DOC_ROOT="/var/www/PS_${PS_VERSION}${TEST_BASE_DIR}"

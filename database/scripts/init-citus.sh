#!/bin/bash

PATH_POSTGRES_BIN=/usr/lib/postgresql/11/bin

# include path to postgres binaries
export PATH=$PATH:$PATH_PROGRESS_BIN

cd ~
mkdir -p citus11/coordinator citus11/worker1 citus11/worker2

# create three normal postgres instances
initdb -D citus11/coordinator
initdb -D citus11/worker1
initdb -D citus11/worker2

# load citus shared library
echo "shared_preload_libraries = 'citus'" >> citus11/coordinator/postgresql.conf
echo "shared_preload_libraries = 'citus'" >> citus11/worker1/postgresql.conf
echo "shared_preload_libraries = 'citus'" >> citus11/worker2/postgresql.conf

# start the db
pg_ctl -D citus11/coordinator -o "-p 9700" -l coordinator_logfile start
pg_ctl -D citus11/worker1 -o "-p 9701" -l worker1_logfile start
pg_ctl -D citus11/worker2 -o "-p 9702" -l worker2_logfile start

# create new role
psql -p 9700 -c "CREATE USER infinitum WITH PASSWORD 'passwd';"
psql -p 9701 -c "CREATE USER infinitum WITH PASSWORD 'passwd';"
psql -p 9702 -c "CREATE USER infinitum WITH PASSWORD 'passwd';"

# export variable

# create new database
psql -p 9700 -c "CREATE DATABASE infinitum WITH OWNER infinitum;"
psql -p 9701 -c "CREATE DATABASE infinitum WITH OWNER infinitum;"
psql -p 9702 -c "CREATE DATABASE infinitum WITH OWNER infinitum;"

# enable citus extension
psql -p 9700 -d infinitum -c "CREATE EXTENSION citus;"
psql -p 9701 -d infinitum -c "CREATE EXTENSION citus;"
psql -p 9702 -d infinitum -c "CREATE EXTENSION citus;"

# add worker to coordinator
psql -p 9700 -d infinitum -c "SELECT * from master_add_node('localhost', 9701);"
psql -p 9700 -d infinitum -c "SELECT * from master_add_node('localhost', 9702);"

# to verify
psql -p 9700 -U infinitum -d infinitum -c "select * from master_get_active_worker_nodes();"


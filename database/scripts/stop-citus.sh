#!/bin/bash

pg_ctl -D citus11/worker2 -o "-p 9702" -l worker2_logfile stop
pg_ctl -D citus11/worker1 -o "-p 9701" -l worker1_logfile stop
pg_ctl -D citus11/coordinator -o "-p 9700" -l coordinator_logfile stop

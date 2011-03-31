#!/bin/bash

echo "DROP DATABASE IF EXISTS sandscape;"
echo "CREATE DATABASE sandscape;"
echo "USE sandscape;"
for file in v*/*.sql; do echo SOURCE "$file"; done;
echo "SOURCE demo.sql;"

#!/bin/bash

# rebuild.sh
# 
# This file is part of SandScape.
# 
# SandScape is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# SandScape is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
# 
# Copyright (c) 2011, the SandScape team and WTactics project.

# This is a small utility script to recreate the database, assuming the name is 
# 'sandscape', and run every script to bring the database to it's newer state.
#
# use it by issuing: sh rebuild.sh | mysql -u <user> -p<password>
echo "DROP DATABASE IF EXISTS sandscape;"
echo "CREATE DATABASE sandscape;"
echo "USE sandscape;"
for file in v*/*.sql; do 
    echo SOURCE "$file"; 
done;
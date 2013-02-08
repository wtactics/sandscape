#!/bin/bash

# rebuild.sh
#
# 
# This file is part of Sandscape, a virtual, browser based, table allowing 
# people to play a customizable card games (CCG) online.
#
# Copyright (c) 2011 - 2013, the Sandscape team.
# 
# Sandscape uses several third party libraries and resources, a complete list 
# can be found in the <README> file and in <_dev/thirdparty/about.html>.
# 
# Sandscape's team members are listed in the <CONTRIBUTORS> file.
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# 
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

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
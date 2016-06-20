#!/bin/bash

DIR_BASE=./screenshots
DIR_ORIGINAL=${DIR_BASE}/original
DIR_OPTIMIZED=${DIR_BASE}/optimized
DIR_PROCESSED=${DIR_BASE}/processed

for i in ${DIR_ORIGINAL}/*.png
do
    echo -n $i > progress
    optipng -o5 -quiet -dir $DIR_OPTIMIZED $i
    
    name=${file##*/}
    mv $i $DIR_PROCESSED/$name
done

echo -n "" > "./progress"

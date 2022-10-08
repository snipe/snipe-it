#!/bin/bash
set -e

imageTag=$(aws ecr describe-images --repository-name snipe --query 'sort_by(imageDetails,& imagePushedAt)[-1].imageTags[0]')
imageTag=`sed -e 's/^"//' -e 's/"$//' <<<"$imageTag"`
# Generate a JSON object containing the image tag

jq -n --arg imageTag "$imageTag" '{"image_tag":$imageTag}'

exit 0



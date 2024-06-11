#!/bin/bash
# Source directory
SOURCE_DIR="/var/www/drp-content-management/sites/app.lifafa.team/files"
# Destination GCS bucket
DEST_BUCKET="s3://lifafa-public-document-upload-storage/lifafa/lifafa.team/drupal/files"
# Perform rsync
aws s3 sync $SOURCE_DIR $DEST_BUCKET --exclude "php/*"
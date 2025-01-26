#!/bin/bash
set -e  # Exit on error

# Environment variables (populated via GitHub Secrets in the workflow)
LOCAL_DB_NAME=$LOCAL_DB_NAME
LOCAL_DB_USER=$LOCAL_DB_USER
LOCAL_DB_PASS=$LOCAL_DB_PASS
AZURE_DB_HOST=$AZURE_DB_HOST
AZURE_DB_NAME=$AZURE_DB_NAME
AZURE_DB_USER=$AZURE_DB_USER
AZURE_DB_PASS=$AZURE_DB_PASS
DUMP_FILE="db-dump.sql"

# Step 1: Export local database
echo "Exporting local database: $LOCAL_DB_NAME..."
mysqldump -u "$LOCAL_DB_USER" -p"$LOCAL_DB_PASS" "$LOCAL_DB_NAME" > $DUMP_FILE

# Step 2: Import dump file into Azure database
echo "Importing dump file into Azure database: $AZURE_DB_NAME..."
mysql --ssl-ca=/Users/morgan.segura/.ssh/DigiCertGlobalRootG2.crt.pem \
      -h "$AZURE_DB_HOST" \
      -u "$AZURE_DB_USER" \
      -p"$AZURE_DB_PASS" \
      "$AZURE_DB_NAME" < $DUMP_FILE

# Step 3: Perform search-and-replace for URLs
echo "Performing search-and-replace on database..."
mysql --ssl-ca=/Users/morgan.segura/.ssh/DigiCertGlobalRootG2.crt.pem \
      -h "$AZURE_DB_HOST" \
      -u "$AZURE_DB_USER" \
      -p"$AZURE_DB_PASS" \
      -e "UPDATE wp_options SET option_value = REPLACE(option_value, 'http://grassrootsfdn.local', 'https://grf-headless.azurewebsites.net') WHERE option_name = 'siteurl' OR option_name = 'home';" "$AZURE_DB_N

#!/bin/bash

# Define variables
LOCAL_DB_NAME="local"
LOCAL_DB_USER="root"
LOCAL_DB_PASS="root"
LOCAL_DB_HOST="127.0.0.1"

AZURE_DB_HOST="grfheadles-c5b4b4cacb-privatelink.mysql.database.azure.com"
AZURE_DB_NAME="grfheadles-c5b4b4cacb-privatelink"
AZURE_DB_USER="bsraawezfi"
AZURE_DB_PASS="csBCtGbt0dX6wmh7KNchPlDfNSprw3grvHHf9WpNSfS93Hgtg8g3LPgitfxz"
AZURE_SSH_USER="kudu_ssh_user"
AZURE_SSH_HOST="https://grf-headless-fbeeesahfucac3a9.westus2-01.azurewebsites.net/"
REMOTE_WP_PATH="waws-prod-mwh-125.ftp.azurewebsites.windows.net/site/wwwroot"

DUMP_FILE="db-sync.sql"

# Step 1: Export the local database
echo "Exporting local database..."
mysqldump -h $LOCAL_DB_HOST -u $LOCAL_DB_USER -p$LOCAL_DB_PASS $LOCAL_DB_NAME > $DUMP_FILE

# Step 2: Transfer the dump file to the Azure server
echo "Transferring dump file to Azure server..."
scp $DUMP_FILE $AZURE_SSH_USER@$AZURE_SSH_HOST:$REMOTE_WP_PATH

# Step 3: Import the database on the Azure server
echo "Importing database on Azure server..."
ssh $AZURE_SSH_USER@$AZURE_SSH_HOST "mysql -h $AZURE_DB_HOST -u $AZURE_DB_USER -p$AZURE_DB_PASS $AZURE_DB_NAME < $REMOTE_WP_PATH/$DUMP_FILE"

# Step 4: Perform search-replace to update URLs
echo "Updating URLs in the database..."
ssh $AZURE_SSH_USER@$AZURE_SSH_HOST "wp search-replace 'http://grassrootsfdn.local/' 'https://grf-headless-fbeeesahfucac3a9.westus2-01.azurewebsites.net/' --path=$REMOTE_WP_PATH --allow-root"

# Step 5: Cleanup
echo "Cleaning up dump file..."
ssh $AZURE_SSH_USER@$AZURE_SSH_HOST "rm $REMOTE_WP_PATH/$DUMP_FILE"
rm $DUMP_FILE

echo "Database sync completed successfully!"

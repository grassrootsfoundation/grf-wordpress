#!/bin/bash
set -e  # Exit immediately if a command exits with a non-zero status

# Load environment variables (optional for local testing)
if [ -f .env ]; then
  export $(cat .env | xargs)
fi


# Define variables
DUMP_FILE="/tmp/db-sync.sql"
LOCAL_DUMP_FILE="db-sync.sql"

# Step 1: Export the local database
echo "Exporting local database..."
mysqldump -h "$LOCAL_DB_HOST" -u "$LOCAL_DB_USER" -p"$LOCAL_DB_PASS" "$LOCAL_DB_NAME" > "$DUMP_FILE"
if [[ $? -ne 0 ]]; then
  echo "Failed to export local database."
  exit 1
fi

# Step 2: Transfer the dump file to the Azure server (using Kudu API)
echo "Transferring dump file to Azure server..."
curl -X PUT \
     -u "$AZURE_SSH_USER:$AZURE_SSH_PASS" \
     --data-binary @"$DUMP_FILE" \
     "https://$AZURE_SSH_HOST/api/vfs/site/wwwroot/db-sync.sql"
if [[ $? -ne 0 ]]; then
  echo "Failed to transfer dump file to Azure server."
  exit 1
fi

# Step 3: Import the database on the Azure server
echo "Importing database on Azure server..."
ssh "$AZURE_SSH_USER@$AZURE_SSH_HOST" "mysql -h $AZURE_DB_HOST -u $AZURE_DB_USER -p'$AZURE_DB_PASS' $AZURE_DB_NAME < /site/wwwroot/db-sync.sql"
if [[ $? -ne 0 ]]; then
  echo "Failed to import database on Azure server."
  exit 1
fi

# Step 4: Perform search-replace to update URLs (using WP-CLI)
echo "Updating URLs in the database..."
ssh "$AZURE_SSH_USER@$AZURE_SSH_HOST" <<EOF
wp search-replace 'http://grassrootsfdn.local/' 'https://grf-headless-fbeeesahfucac3a9.westus2-01.azurewebsites.net/' \
    --path=/site/wwwroot --allow-root
EOF
if [[ $? -ne 0 ]]; then
  echo "Failed to update URLs in the database."
  exit 1
fi

# Step 5: Cleanup
echo "Cleaning up dump file..."
curl -X DELETE \
     -u "$AZURE_SSH_USER:$AZURE_SSH_PASS" \
     "https://$AZURE_SSH_HOST/api/vfs/site/wwwroot/db-sync.sql"
rm -f "$DUMP_FILE"

echo "Database sync completed successfully!"

set -e

echo "Removing invalid mods"
cd mod

echo "Removing core mods"

find . -name manifest.xml -exec grep -q bundled '{}'  \; -print | xargs -n 1 dirname | xargs -n 1 rm -rf

echo "Removing superfluous mods"

rm -rf data_views
rm -rf roles
rm -rf roles_ui
rm -rf user_api
rm -rf discussions_api

echo "Removing unsupported mods"

rm -rf hypeUI
rm -rf event_calendar
rm -rf hypeNotifications
rm -rf hypeEmbed
rm -rf hypeLists
rm -rf wabue

echo "Updating supported mods"

rm -rf autosubscribegroup && wget "https://elgg.org/plugins/download/2915583" && unzip 2915583 && rm 2915583
rm -rf content_subscriptions && wget "https://github.com/ColdTrick/content_subscriptions/releases/download/v6.0.1/content_subscriptions_v6.0.1.zip" && unzip content_subscriptions_v6.0.1.zip && rm content_subscriptions_v6.0.1.zip
rm -rf elgg_update_services && wget "https://elgg.org/plugins/download/2917092" && unzip 2917092 && rm 2917092
rm -rf favicon_override && wget "https://elgg.org/plugins/download/2915643" && unzip 2915643 && rm 2915643
rm -rf menu_builder && wget "https://elgg.org/plugins/download/2918200" && unzip 2918200 && rm 2918200
rm -rf poll && wget "https://github.com/ColdTrick/poll/releases/download/v4.2/poll_v4.2.zip" && unzip poll_v4.2.zip && rm poll_v4.2.zip
rm -rf profile_manager && wget "https://elgg.org/plugins/download/2918295" && unzip 2918295 && rm 2918295
rm -rf site_announcements && wget "https://elgg.org/plugins/download/2922421" && unzip 2922421 && rm 2922421
rm -rf login_as && wget "https://github.com/Elgg/login_as/archive/2.0.0.zip" && unzip 2.0.0.zip && mv login_as-2.0.0/ login_as && rm 2.0.0.zip

cd ..

echo "rsyncing vendor"

rsync -av --delete ~/Downloads/elgg-3.1.4/vendor/ vendor/

echo "Reinjecting core mods"

cp -pr vendor/elgg/elgg/mod/* mod

echo "Adding additional mods"

# ckeditor extended
wget "https://elgg.org/plugins/download/2918098" && unzip 2918098 && rm 2918098

# event calendar rc for elgg 3
git clone -b issue-14 https://github.com/wabuehamm/event_calendar.git

# wabue rc for elgg 3
git clone -b elggv3 https://github.com/wabuehamm/elgg-plugin-wabue.git wabue

echo "Starting upgrade"

curl -k -f https://web:8443/upgrade.php

echo "Fixing database"

docker cp mod/wabue/update3.sql mitglieder_db_1:/update3.sql
docker exec mitglieder_db_1 /usr/bin/mysql --password=secret mitglieder -e '\. /update3.sql'

echo "Opening browser for further upgrades"

open https://web:8443/upgrade/init

# Things after the update
# Enable ckeditor plugin (tinymce is deprecated)
# Enable ckeditor extended
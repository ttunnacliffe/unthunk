# Unthunk WordPress site

Source baseline for https://unthunk.ca, hosted on DigitalOcean.

## Imported code

The active `t-one` theme (version 1.6), extracted from the supplied September 28, 2026 backup, is in `wp-content/themes/t-one`. A bundled Google API key default was removed before import.

WordPress core, third-party plugins, uploads, database dumps, server configuration, credentials, and backup archives are excluded. The original backup remains separate and is required to recreate site content and settings locally.

## Theme replacement

Develop and preview the replacement on a local or staging WordPress installation restored from the backup. The current theme registers a `tracks` post type and a `[year]` shortcode in `functions.php`; preserve these behaviors in a site plugin before changing themes. Review templates, custom fields, navigation, and theme options against the restored database.

## Deployment

No automatic deployment is configured. Changes in this repository do not change the live site. Restore and test in staging, back up production, then deploy reviewed theme files and activate the replacement through WordPress.

## Plugin inventory from backup

all-in-one-seo-pack, duplicator, email-log, go-live-update-urls, google-analytics-for-wordpress, mainwp-child, post-types-order, runcloud-hub, soundcloud-shortcode, sucuri-scanner, wp-mail-smtp.

This is an installed-plugin inventory, not a claim that every plugin is active. Use the backup to restore the exact plugin versions.

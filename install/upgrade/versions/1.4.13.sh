#!/bin/bash

# Hestia Control Panel upgrade script for target version 1.4.13

#######################################################################################
#######                      Place additional commands below.                   #######
#######################################################################################
####### New Feature: UPGRADE_MESSAGE                                            #######
#######                                                                         #######
####### Add your text to UPGRADE_MESSAGE to include a message to the upgrade    #######
####### email. Do not overwrite the variable, it could already contains prior   #######
####### content of another upgrade script. Please add it using:                 #######
#######                                                                         #######
####### UPGRADE_MESSAGE="$UPGRADE_MESSAGE\nYour Upgrade Notification Text"      #######
#######                                                                         #######
####### Always start and end with \n to generate a new line.                    #######
#######################################################################################


# Check if hostname is valid according to RFC1178
if [[ $(echo "$servername" | grep -o "\." | wc -l) -lt 2 ]] || [[ $servername =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]];; then
    UPGRADE_MESSAGE="$UPGRADE_MESSAGE\nWe've noticed that you're using a invalid hostname. Please have a look at the RFC1178 standard (https://datatracker.ietf.org/doc/html/rfc1178) and use a valid one (ex. hostname.domain.tld). You can change the hostname using v-change-sys-hostname and also add a ssl certificate using v-add-letsencypt-host (proper dns A record mandatory). You'll find more informations in our documentation: https://docs.hestiacp.com/admin_docs/web/ssl_certificates.html#how-to-setup-let-s-encrypt-for-the-control-panel"
fi
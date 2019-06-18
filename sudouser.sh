#!/bin/bash
#/ Usage: snipeit.sh [-vh]
#/
#/ Install Snipe-IT open source asset management.
#/
#/ OPTIONS:
#/   -v | --verbose    Enable verbose output.
#/   -h | --help       Show this message.

######################################################
#           Snipe-It Install Script                  #
#          Script created by Mike Tucker             #
#            mtucker6784@gmail.com                   #
#                                                    #
# Feel free to modify, but please give               #
# credit where it's due. Thanks!                     #
######################################################

# Parse arguments
adduser snipeit
usermod -aG sudo snipeit
su - snipeit

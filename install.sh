#!/bin/bash

echo -e ''
echo -e "\033[32m============ NetBird for pfSense Installation Script ==============\033[0m"
echo -e ''

# Define color variables
GREEN="\033[32m"
YELLOW="\033[33m"
RED="\033[31m"
CYAN="\033[36m"
RESET="\033[0m"

# Define directory variables
ROOT="/usr/local"
WWW_DIR="$ROOT/www"
BIN_DIR="$ROOT/bin"
MENU_DIR="$ROOT/share/pfSense/menu"

# Define log function
log() {
    local color="$1"
    local message="$2"
    echo -e "${color}${message}${RESET}"
}

# Install Netbird
log "$YELLOW" "Installing Netbird..."
pkg add -f bin/netbird.pkg
cp -f bin/netbird "$BIN_DIR/" || log "$RED" "Failed to copy bin file!"
echo ""

# Copy files
log "$YELLOW" "Copying files..."

log "$YELLOW" "Generating menu..."
cp -f www/* "$WWW_DIR/" || log "$RED" "Failed to copy www files!"
cp -R menu/* "$MENU_DIR/" || log "$RED" "Failed to copy menu files!"

# Configure system service
log "$YELLOW" "Configuring system service..."
sysrc netbird_enable="YES"
echo ""

# Add execute permissions
log "$YELLOW" "Adding execute permissions..."
chmod +x /usr/local/bin/netbird

# Register node
log "$YELLOW" "Registering node..."
log "$GREEN" "Follow the instructions and enter the authentication link in your browser, click confirm, and complete the authentication."
sh bin/initialup.sh

# Set startup script
log "$YELLOW" "Adding startup command:"
log "$GREEN" "Add [service netbird start] in the shellcmd plugin."
echo ""

# Completion message
log "$YELLOW" "Installation completed..."
echo ""
log "$GREEN" "Navigate to VPN > NetBird to check the connection status."
log "$GREEN" "To allow node communication, you also need to add the wt0 virtual network interface as an interface, enter the IP address assigned to the node, and add firewall rules on the interface."
echo ""

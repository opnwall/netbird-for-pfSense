# NetBird for pfSense
![NetBird Logo](image/netbird-logo.png)

This is a control program for **NetBird** that can be used on pfSense. The web control code is assisted by ChatGPT and provides simple functionality for controlling and viewing node status. The compiled version of the NetBird program is **0.36.3**.

## Prerequisites

Before installation, ensure that you have completed the following steps:

1. Register a **NetBird** account and access the control panel.
2. Allow WireGuard's default communication port on the firewall's **WAN** interface.

## Installation Steps

### 1. Download and Upload

1. Download the attachment, unzip it, and upload it to the root directory of the firewall.
2. Navigate to the file directory and run the following command to start the installation:

    ```bash
    sh install.sh
    ```

### 2. Installation Process

During installation, you will see output similar to the following:

```bash
Installing Netbird...
Installing netbird-0.31.0...
pkg: wrong architecture: FreeBSD:14:amd64 instead of FreeBSD:15:amd64
package netbird is already installed, forced install
Extracting netbird-0.31.0: 100%
=====
Message from netbird-0.31.0:

--
At this time this code is new, unvetted, possibly buggy, and should be
considered "experimental". It might contain security issues. We gladly
welcome your testing and bug reports, but do keep in mind that this code
is new, so some caution should be exercised at the moment for using it
in mission critical environments.

Copying files...
Generating menu...
Configuring system service...
netbird_enable: YES -> YES

Adding execute permissions...
Registering node...
Follow the instructions and enter the authentication link in your browser, click confirm, and complete the authentication.
Stopping netbird.
Waiting for PIDS: 14120.
Deleting old configuration file
netbird 11345 - - Starting netbird.
Please do the SSO login in your browser. 
If your browser didn't open automatically, use this URL to log in:

https://login.netbird.io/activate?user_code=PGMX-CJCT 

Alternatively, you may want to use a setup key, see:

https://docs.netbird.io/how-to/register-machines-using-setup-keys
Connected
Adding startup command:
Add [service netbird start] in the shellcmd plugin.

Installation completed...

Navigate to VPN > NetBird to check the connection status.
To allow node communication, you also need to add the wt0 virtual network interface as an interface, enter the IP address assigned to the node, and add firewall rules on the interface.

```

3. Follow the instructions and enter the authentication link in your browser to activate:
   
    - The browser will display a confirmation page; click confirm to complete the authentication.
    - In the NetBird web console, you will see the authenticated device node. Click the option on the right and enable "Disable session expiry" to keep the node online permanently.

4. Navigate to `VPN > NetBird` to view the NetBird node information and control the program's operation.
![NetBird web](image/11.png)

## Adding Routes

To ensure mutual access between NetBird nodes, you need to add a **All to All** rule in the NetBird control console.

1. Go to the console, click on the left navigation bar, select`Polices`, and then click "Add Policy".
2. Click the "Add" button, select **All** for both the source and destination, enable the policy, and then click "Continue".
3. Based on the access control policy, non-commercial users might not have this feature. Click "Continue".
4. Enter a name and description for the policy, then click the "Add Policy" button to complete.

## Testing

Ping the remote node addresses from each node to check connectivity.

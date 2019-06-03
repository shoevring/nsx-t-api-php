# Requirements: Install PowerCLI / Install-Module VMware.PowerCLI
# Connect to vCenter and run below command to get list of Vlans, to use for the make_segment script.

Get-VirtualPortGroup | Select Name,@{N="VLANId";E={$_.Extensiondata.Config.DefaultPortCOnfig.Vlan.VlanId}} | Convertto-json

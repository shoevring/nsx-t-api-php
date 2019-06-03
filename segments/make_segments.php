<?php
		
	# Global Variables
		$TransportZoneID = "";
		$DisplayNamePrefix = "NSX_";
		$NSXManagerHostName = "nsx-manager.local";
    		$JSONSourcePath = "./vlans.json"; // Could be url, or simple
    		$NSXManagerUserName = "";
    		$NSXManagerPassword = "";
		
	# Get Data
		$jsondata = json_decode(file_get_contents($JSONSourcePath), true);
	
	foreach ($jsondata as $vlaninfo)
	{
		
		# Get Json Data
			$VLANid = $vlaninfo['VLANId'];
		
		# Make Input/Post data	
			$MakePostData = array("vlan_ids" => array($VLANid), 
			"transport_zone_path" => "/infra/sites/default/enforcement-points/default/transport-zones/".$TransportZoneID."", 
			"resource_type" => "Segment",
			"id" => "VLAN".$VLANid."",
			"display_name" => "".$DisplayNamePrefix."".$VLANid."",
			"path" => "/infra/segments/VLAN".$VLANid."",
			"relative_path" => "VLAN".$VLANid."",
			"parent_path" => "/infra/segments/VLAN".$VLANid."");
			
			$data_string = json_encode($MakePostData);
	
		# Run CURL
		
			$ch = curl_init("https://".$NSXManagerHostName."/policy/api/v1/infra/segments/".$VLANid."");                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // If you have valid certificate, then yes
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // If you have valid certificate, then yes
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, "".$NSXManagerUserName.":".$NSXManagerPassword.""); 			
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json')                                                                       
			);                                                                                                                   
																													
			$result = curl_exec($ch);
			
			$dataresult = json_decode($result, true);
		
		# Print Result for each
			print_r($dataresult);
		
	
	}

?>

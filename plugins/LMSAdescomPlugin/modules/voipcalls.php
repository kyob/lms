<?php

$layout['pagetitle'] = trans('List of current VOIP calls');

$ctm_manager = new AdescomCTMManager();
$trunk_manager = new AdescomTrunkManager();

$ctms = $ctm_manager->getCTMNodes();

$all_channels = array();

foreach ($ctms as $ctm) {
    $temp_channels = $trunk_manager->GetChannels($ctm['id']);


    $channels = array();

    if (is_array($temp_channels)) {
        $temp_channels = ArrayHelper::arrayToAssoc($temp_channels, 'id');
        
        $seen_channels = array();

        foreach ($temp_channels as $id => $left_channel) {
            if (in_array($id, $seen_channels)) {
                continue;
            }

            $state = $left_channel['state'];

            $bridged_id = ArrayHelper::arrayGetValue('bridged_id', $left_channel);

            if ($bridged_id !== null) {
                $right_channel = isset($temp_channels[$bridged_id]) ? $temp_channels[$bridged_id] : null;
                $seen_channels[] = $bridged_id;
            } else {
                $right_channel = null;
            }

            $billsec = ArrayHelper::arrayGetValue('billsec', $left_channel);

            if ($billsec === null) {
                $billsec = ArrayHelper::arrayGetValue('billsec', $right_channel);
            }

            if ($billsec !== null) {
                $channel_pair['billsec'] = $billsec;
            }

            $channel_pair['left'] = $left_channel;
            $channel_pair['right'] = $right_channel;

            $channels[] = $channel_pair;
        }
    }

    $ctm_entry = array();

    $ctm_entry['ctm_name'] = $ctm['name'];
    $ctm_entry['channels'] = $channels;

    $all_channels[] = $ctm_entry;
}

$SMARTY->assign('channels', $all_channels);

$SMARTY->display('voipaccount/voipcalls.html');

<?php
    $startTime = microtime(true);

    echo 'Started validation at '.date('h:i:s M d, Y').'...'."\n";


    $base = '/Users/dasfisch/cron_results/';

    $badDataFile = $base.'bad_data.xml'; // List of xml elements that have failed
    $errorFile = $base.'all_errors.txt';
    $nextDataSetFile = $base.'current_batch.txt';
    $readableErrorFile = $base.'our_errors.txt';

    $readFile = $base.'user_export.xml';

    $errorFileHandle = fopen($errorFile, 'a+');
    $readableErrorFileHandle = fopen($readableErrorFile, 'a+');

    if(file_exists($nextDataSetFile)) {
        $batchHandle = fopen($nextDataSetFile, 'w+');

        $nextDataSet = fread($batchHandle, 1024);

        $nextDataSet = (int)trim($nextDataSet);
    } else {
        $batchHandle = fopen($nextDataSetFile, 'w+');

        $nextDataSet = 0;
    }

    echo 'The next batch is '.$nextDataSet."\n";

    if(file_exists($readFile)) {
        echo 'Starting file load at '.date('h:i:s M d, Y').'...'."\n";

        $xml = simplexml_load_file($readFile);

        echo 'Finished file load at '.date('h:i:s M d, Y').'...'."\n";
        echo 'Starting validation at '.date('h:i:s M d, Y').'...'."\n";

        $startTimeAfterFile = microtime(true);

        for($i = $nextDataSet; $i < 10000; $i++) {
            $ourError = '';

            if(!isset($xml->user[$i]->email) || !preg_match('/^.+@.+?\.[a-zA-Z]{2,}$/', $xml->user[$i]->email)) {
                $xml->user[$i]->posInArray = $i;

                $badData[] = $xml->user[$i];

                $ourError .= 'ERROR:'."\n";
                $ourError .= 'Recorded at '.date('h:i:s M d, Y', strtotime('now'))."\n";
                $ourError .= 'User '.$i.' does not have a valid email: '.$xml->user[$i]->email."\n";
                $ourError .= "\n";

                echo $ourError;

                //do logging;
                fwrite($readableErrorFileHandle, $ourError);
                fwrite($errorFileHandle, $i.',');

                //user is not valid, no sense in further validating their shit.
                continue;
            }

            if(!isset($xml->user[$i]->screen_name) || strlen($xml->user[$i]->screen_name) > 18) {
                $xml->user[$i]->posInArray = $i;

                $badData[] = $xml->user[$i];

                $ourError .= 'SCREEN NAME ERROR:'."\n";
                $ourError .= 'Recorded at '.date('h:i:s M d, Y', strtotime('now'))."\n";
                $ourError .= 'User '.$i.' does not have a valid screenname: '.$xml->user[$i]->screen_name."\n";
                $ourError .= "\n";

                echo $ourError;

                //do logging;
                fwrite($readableErrorFileHandle, $ourError);
                fwrite($errorFileHandle, $i.',');

                //user is not valid, no sense in further validating their shit.
                continue;
            }

            if(!isset($xml->user[$i]->guid) || $xml->user[$i]->guid == '') {
                $xml->user[$i]->posInArray = $i;

                $badData[] = $xml->user[$i];

                $ourError .= 'GUID ERROR:'."\n";
                $ourError .= 'Recorded at '.date('h:i:s M d, Y', strtotime('now'))."\n";
                $ourError .= 'User '.$i.' does not have a valid guid: '.$xml->user[$i]->guid."\n";
                $ourError .= "\n";

                echo $ourError;

                //do logging;
                fwrite($readableErrorFileHandle, $ourError);
                fwrite($errorFileHandle, $i.',');

                //user is not valid, no sense in further validating their shit.
                continue;
            }

            if(!isset($xml->user[$i]->display_name) || $xml->user[$i]->display_name == '') {
                $xml->user[$i]->posInArray = $i;

                $badData[] = $xml->user[$i];

                $ourError .= 'DISPLAY NAME ERROR:'."\n";
                $ourError .= 'Recorded at '.date('h:i:s M d, Y', strtotime('now'))."\n";
                $ourError .= 'User '.$i.' does not have a valid display_name: '.$xml->user[$i]->display_name."\n";
                $ourError .= "\n";

                echo $ourError;

                fwrite($readableErrorFileHandle, $ourError);
                fwrite($errorFileHandle, $i.',');

                //user is technially valid; we can create this data
            }
        }

        echo 'Finished validation at '.date('h:i:s M d, Y').'...'."\n";

        $nextDataSet += 10000;
        
        fwrite($batchHandle, $nextDataSet);
        
        // Create the XML with all data issues
        $xml = new SimpleXMLElement('<users/>');

        foreach($badData as $key=>$val) {
            $user = $xml->addChild('user');

            $user->addChild('posInArray', $val->posInArray);
            $user->addChild('id', $val->id);
            $user->addChild('screen_name', $val->screen_name);
            $user->addChild('email', $val->email);
            $user->addChild('display_name', $val->display_name);
            $user->addChild('first_name', $val->first_name);
            $user->addChild('last_name', $val->last_name);
            $user->addChild('guid', $val->guid);
        }

        // Saving pretty XML
        $dom = new DOMDocument('1.0');

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        $dom->save($badDataFile);

        $endTime = microtime(true);
        echo $endTime - $startTimeAfterFile;
        echo ' is the elapsed time to validate out '.$i.' users'."\n";
        echo $endTime - $startTime;
        echo ' is the elapsed time to load the file and validate out '.$i.' users';
        exit(0);
    } else {
        echo 'there is no file to read!';
    }
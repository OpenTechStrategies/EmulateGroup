<?php

class EmulateGroup {
  public static function onLoadExtensionSchemaUpdates($updater) {
    $dir = __DIR__ . '/../sql';
    $updater->addExtensionTable('EmulateGroupCurrentlyEmulating', "{$dir}/currentlyemulating.sql");
    $updater->addExtensionTable('EmulateGroupRealGroup', "{$dir}/realgroup.sql");
  }

  public static function onSidebarBeforeOutput(Skin $skin, &$bar) {
    global $wgGroupPermissions, $wgUser, $wgEmulateGroupGroupList;

    if($wgUser->isSafeToLoad()) {
      $dbw = wfGetDB(DB_MASTER);
      $resp = $dbw->select("EmulateGroupCurrentlyEmulating", ["group_name"], ["user_id" => $wgUser->getId()]);
      if($dbw->numRows($resp) > 0) {
        $currently_emulating = $resp->next()->group_name;
        $out = "<div class='emulategroup-emulating'>";
        $out .= wfMessage("emulategroup-currently");
        $out .= "<br>";
        $out .= "<span style='overflow:hidden' class='currentlyemulating'>$currently_emulating</span>";
        $out .= "</div>";
        $out .= "<input id='emulategroupstop' type='button' value='" . wfMessage("emulategroup-stop") . "'>";
        $bar['Emulate'] = $out;
      } else if($wgUser->isAllowed("emulategroup")) {
        $out = "<div class='emulategroup-selections'>";
        $out .= "<select id='emulategroupgroup' autocomplete=off name='emulate-group-select'>";
        if(!$wgEmulateGroupGroupList) {
          $perms = array_keys($wgGroupPermissions);
          sort($perms);
        } else if(is_callable($wgEmulateGroupGroupList)) {
          $perms = call_user_func($wgEmulateGroupGroupList);
        } else {
          $perms = $wgEmulateGroupGroupList;
        }
        foreach($perms as $groupName) {
          $out .= "<option value='$groupName'>$groupName</option>";
        }
        $out .= "</select>";
        $out .= "<input id='emulategroupsubmit' type='button' value='" . wfMessage("emulategroup-start") . "'>";
        $out .= "</div>";
        $bar['Emulate'] = $out;
      }
    }

    return true;
  }

  public static function onBeforePageDisplay(OutputPage $out, Skin $skin) {
    $out->addModules('ext.emulategroup.js');
  }
}

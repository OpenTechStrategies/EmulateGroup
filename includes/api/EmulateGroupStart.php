<?php

class EmulateGroupStart extends ApiBase {
  public function execute() {
    $user = $this->getUser();
    $dbw = wfGetDB(DB_MASTER);
    $user_id = $this->getUser()->getId();
    $group_in = $this->getRequest()->getVal('group');

    $dbw->insert(
      'EmulateGroupCurrentlyEmulating',
      [
        'user_id' => $user_id,
        'group_name' => $group_in
      ]
    );

    foreach($user->getGroups() as $group) {
      $dbw->insert(
        'EmulateGroupRealGroup',
        [
          'user_id' => $user_id,
          'group_name' => $group
        ]
      );
    }
    foreach($user->getGroups() as $group) {
      $user->removeGroup($group);
    }
    $user->addGroup($group_in);

    return true;
  }

  public function needsToken() {
    return 'csrf';
  }

  public function getAllowedParams() {
    return [
      "group" => [
        ApiBase::PARAM_REQUIRED => true,
        ApiBase::PARAM_TYPE => "string"
      ]
    ];
  }
}

?>

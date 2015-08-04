<?php
/*
* This file is part of enviroCar.
* 
* enviroCar is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* enviroCar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with enviroCar.  If not, see <http://www.gnu.org/licenses/>.
*/

include('header.php');
?>

<div id="badgesModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
      ×
    </button>
    <h3 id="myModalLabel">
      <?php echo $availableBadges ?>
    </h3>
  </div>
  <div class="modal-body">
    <ul id="all-badges">
    </ul>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">
      Close
    </button>
  </div>
</div>

<div id="accept_terms_div" class="container alert alert-block alert-info fade in" style="display:none">
  
  <?php echo $please_accept_terms ?>
  
  <input type="button" name="Text 2" value="<? echo $confirm_accept_terms ?>" onclick="acceptTerms()">
    
</div>


<div class="container leftband">
  <div class="row-fluid">
    <div class="span3">
      <div class="row">
        <div class="span12">
          <img src="./assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
          <h2 id="username">
          </h2>
          <ul id="userInformation" class="nav nav-list">
          </ul>
          <ul id="overallStatistics" class="nav nav-list">
          </ul>
          <h3 class="muted">
            <?php echo $badges ?>
          </h3>
          <ul class="nav nav-list" id="badges">
            <li>
              <small>
                <a href="#" data-toggle="modal" data-target="#badgesModal" class="link">
                  <i class="icon-plus-sign">
                  </i>
                  <?php echo $availableBadges ?>
                </a>
              </small>
            </li>
            
          </ul>
          </div>
      </div>
      <div class="row">
        <div class="span12">
          <h3 class="muted">
            <?php echo $friends ?>
          </h3>
          <input id="searchfriends" type="text" name="text" placeholder="<? echo $searchfriends ?>" data-provide="typeahead"/>
          <div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
          </div>
          
          <ul class="nav nav-list" id="friendsList">
            <li id="show-all-friends">
              <small>
                <a href="friends.php">
                  <i class="icon-plus-sign">
                  </i>
                  <?php echo $dashboard_show_all; ?>
                </a>
              </small>
            </li>
            
          </ul>
          
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <h3 class="muted">
            <?php echo $groups; ?>
          </h3>
          <input id="searchgroups" type="text" name="text" placeholder="<? echo $searchgroups; ?>" data-provide="typeahead"/>
          <small>
            <a href="#create_group_modal" class="link" data-toggle="modal">
              <i class="icon-plus-sign">
              </i>
              <?php echo $creategroup; ?>
            </a>
          </small>
          <div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
          </div>
          <ul class="nav nav-list" id="groupsList">
            <li>
              <small>
                <a href="groups.php">
                  <i class="icon-plus-sign">
                  </i>
                  <?php echo $dashboard_show_all; ?>
                </a>
              </small>
            </li>
            
          </ul>
          
        </div>
      </div>
    </div>
    
    
    <div class="span9">
      <div class="row-fluid">
        <div class="span12" id="comparison">
          <h2>
            <?php echo $dashboard_overview; ?>
          </h2>
          <div id="chart_div" style="width: 700px; height: 400px;">
            
            <div id="loadingIndicator_graph" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none">
            </div>
          </div>
        </div>
        <hr class="featurette-divider">
      </div>
      
      <div class="row-fluid">
        <div class="span12" id="tracks-span">
          <h2>
            <?php echo $dashboard_my_tracks; ?>
          </h2>
          <div id="tracks-pagination">
          </div>
          <div id="loadingIndicator_tracks" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
          </div>
          <div id="tracks-list" class="span12">
          </div>
      </div>
      </div>
    </div>
  </div>
  
</div>

<div id="loadingIndicator" class="loadingIndicator" style="display:none">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px">
  </div>
</div>
<div id="create_group_modal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
      &times;
    </button>
    <h3>
      <?php echo $creategroup; ?>
    </h3>
  </div>
  <div class="modal-body">
    <form id="createGroupForm" action="./assets/includes/groups.php?createGroup" method="post">
      <label for="group_name">
        <?php echo $groupname; ?>
        </label>
        <input id="group_name" type="text" class="input-block-level" placeholder="<? echo $groupname; ?>">
        <label for="group_description">
          <?php echo $groupdescription; ?>
        </label>
        <input id="group_description" type="text" class="input-block-level" placeholder="<? echo $groupdescription; ?>">
        <input type="submit" class="btn btn-primary" value="<? echo $creategroup;?>">
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">
        <?php echo $close; ?>
      </button>
    </div>
</div>

</div>
</div>


<?php
include('footer.php');
?>

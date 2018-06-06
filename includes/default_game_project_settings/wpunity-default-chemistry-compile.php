<?php

function wpunity_create_chemistry_mainmenu_unity($scene_post,$scene_type_ID,$scene_id,$gameSlug,$game_path,$settings_path,$handybuilder_file){
    //DATA of mainmenu
    $term_meta_s_mainmenu = get_term_meta($scene_type_ID,'wpunity_yamlmeta_s_mainmenu_chem',true);
    $title_text = $scene_post->post_title;
    //$is_bt_settings_active = intval ( get_post_meta($scene_id,'wpunity_menu_has_options',true) ); //Future Addition to Yaml
    $is_bt_settings_active = 1; //Always ON
    //$is_help_bt_active = intval ( get_post_meta($scene_id,'wpunity_menu_has_help',true) ); //Future Addition to Yaml
    $is_help_bt_active = 1; //Always ON
    //$is_login_bt_active = intval ( get_post_meta($scene_id,'wpunity_menu_has_login',true) ); //Future Addition to Yaml
    $is_login_bt_active = 1; //Always ON
    $is_exit_button_active = 1;  //Always ON
    $featured_image_sprite_id = get_post_thumbnail_id( $scene_id );//The Featured Image ID
    $featured_image_sprite_guid = 'dad02368a81759f4784c7dbe752b05d6';//if there's no Featured Image

    if($featured_image_sprite_id != ''){
        $featured_image_sprite_guid = wpunity_compile_sprite_upload($featured_image_sprite_id, $gameSlug, $scene_id);
    }

    $file_content = wpunity_replace_mainmenu_chem_unity($term_meta_s_mainmenu,$title_text,$featured_image_sprite_guid,$is_bt_settings_active,$is_help_bt_active,$is_exit_button_active,$is_login_bt_active);

    $file = $game_path . '/' . 'S_MainMenu.unity';
    $create_file = fopen($file, "w") or die("Unable to open file!");
    fwrite($create_file, $file_content);
    fclose($create_file);

    $fileEditorBuildSettings = $settings_path . '/EditorBuildSettings.asset';//path of EditorBuildSettings.asset
    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_MainMenu.unity');//Update the EditorBuildSettings.asset by adding new Scene
    $file1_path_CS = 'Assets/scenes/' . 'S_MainMenu.unity';
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file1_path_CS);

    //Add Static Pages to cs & BuildSettings (Main Menu must be first)
    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_Reward.unity');//Update the EditorBuildSettings.asset by adding new Scene
    $file_path_rewCS = 'Assets/scenes/' . 'S_Reward.unity';
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file_path_rewCS);

    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_SceneSelector.unity');//Update the EditorBuildSettings.asset by adding new Scene
    $file_path_selCS = 'Assets/scenes/' . 'S_SceneSelector.unity';
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file_path_selCS);

    if($is_bt_settings_active == '1'){
        //CREATE SETTINGS/OPTIONS Unity file
        $term_meta_s_settings = get_term_meta($scene_type_ID,'wpunity_yamlmeta_s_options_chem',true);
        $file_content2 = wpunity_replace_settings_chem_unity($term_meta_s_settings);

        $file2 = $game_path . '/' . 'S_Settings.unity';
        $create_file2 = fopen($file2, "w") or die("Unable to open file!");
        fwrite($create_file2,$file_content2);
        fclose($create_file2);

        wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_Settings.unity');//Update the EditorBuildSettings.asset by adding new Scene
        $file2_path_CS = 'Assets/scenes/' . 'S_Settings.unity';
        wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file2_path_CS);
    }

    if($is_help_bt_active == '1'){
        //CREATE HELP Unity file
        $term_meta_s_help = get_term_meta($scene_type_ID,'wpunity_yamlmeta_s_help_chem',true);
        $text_help_scene = get_post_meta($scene_id,'wpunity_scene_help_text',true);
        $img_help_scene_id = get_post_meta($scene_id,'wpunity_scene_helpimg',true);
        $img_help_scene_guid = 'dad02368a81759f4784c7dbe752b05d6'; //if there's no Featured Image (custom field at Main Menu)
        $imgbg_help_scene_guid = 'dad02368a81759f4784c7dbe752b05d6';
        if($img_help_scene_id != ''){$img_help_scene_guid = wpunity_compile_sprite_upload($img_help_scene_id,$gameSlug,$scene_id);}
        $file_content3 = wpunity_replace_help_chem_unity($term_meta_s_help,$text_help_scene,$img_help_scene_guid,$imgbg_help_scene_guid);

        $file3 = $game_path . '/' . 'S_Help.unity';
        $create_file3 = fopen($file3, "w") or die("Unable to open file!");
        fwrite($create_file3, $file_content3);
        fclose($create_file3);

        wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_Help.unity');//Update the EditorBuildSettings.asset by adding new Scene
        $file3_path_CS = 'Assets/scenes/' . 'S_Help.unity';
        wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file3_path_CS);
    }

    if($is_login_bt_active == '1'){
        //CREATE Login Unity file
        $term_meta_s_login = get_term_meta($scene_type_ID,'wpunity_yamlmeta_s_login_chem',true);
        $WanderAroundScene_title = 'S_Lab';

        $file_content4 = wpunity_replace_login_chem_unity($term_meta_s_login,$WanderAroundScene_title);

        $file4 = $game_path . '/S_Login.unity';
        $create_file4 = fopen($file4, "w") or die("Unable to open file!");
        fwrite($create_file4,$file_content4);
        fclose($create_file4);

        wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_Login.unity');//Update the EditorBuildSettings.asset by adding new Scene
        $file4_path_CS = 'Assets/scenes/' . 'S_Login.unity';
        wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file4_path_CS);
    }


}

function wpunity_create_chemistry_credentials_unity($scene_post,$scene_type_ID,$scene_id,$gameSlug,$game_path,$settings_path,$handybuilder_file){
    //DATA of Credits Scene
    $term_meta_s_credits = get_term_meta($scene_type_ID,'wpunity_yamlmeta_s_credentials_chem',true);
    $credits_content = $scene_post->post_content;

    $featured_image_sprite_id = get_post_thumbnail_id( $scene_id );//The Featured Image ID
    $featured_image_sprite_guid = 'dad02368a81759f4784c7dbe752b05d6'; //if there's no Featured Image

    $background_image_sprite_guid = 'dad02368a81759f4784c7dbe752b05d6'; //there's no Background Image

    if($featured_image_sprite_id != ''){$featured_image_sprite_guid = wpunity_compile_sprite_upload($featured_image_sprite_id,$gameSlug,$scene_id);}
    $file_content5 = wpunity_replace_creditsscene_chem_unity($term_meta_s_credits,$credits_content,$featured_image_sprite_guid,$background_image_sprite_guid);

    $file5 = $game_path . '/' . 'S_Credits.unity';
    $create_file5 = fopen($file5, "w") or die("Unable to open file!");
    fwrite($create_file5, $file_content5);
    fclose($create_file5);

    $fileEditorBuildSettings = $settings_path . '/EditorBuildSettings.asset';//path of EditorBuildSettings.asset
    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,'Assets/scenes/S_Credits.unity');//Update the EditorBuildSettings.asset by adding new Scene
    $file5_path_CS = 'Assets/scenes/' . 'S_Credits.unity';
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $file5_path_CS);

}

function wpunity_create_chemistry_exam2d_unity($scene_post,$scene_type_ID,$scene_id,$gameSlug,$game_path,$settings_path,$handybuilder_file,$scenes_counter,$gameType){

    $exam_slug = $scene_post->post_name;

    $term_meta_exam2d_chem = get_term_meta($scene_type_ID,'wpunity_yamlmeta_exam_pat',true);
    $file_contentA = wpunity_replace_chemistry_exam2D_unity($term_meta_exam2d_chem,$scene_id);

    $fileA = $game_path . '/' . $exam_slug . '.unity';
    $create_fileA = fopen($fileA, "w") or die("Unable to open file!");
    fwrite($create_fileA, $file_contentA);
    fclose($create_fileA);

    $fileEditorBuildSettings = $settings_path . '/EditorBuildSettings.asset';//path of EditorBuildSettings.asset
    $fileApath_forCS = 'Assets/scenes/' . $exam_slug . '.unity';
    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,$fileApath_forCS);//Update the EditorBuildSettings.asset by adding new Scene
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $fileApath_forCS);
}

function wpunity_create_chemistry_exam3d_unity($scene_post,$scene_type_ID,$scene_id,$gameSlug,$game_path,$settings_path,$handybuilder_file,$scenes_counter,$gameType){

    $exam_slug = $scene_post->post_name;

    $term_meta_exam3d_chem = get_term_meta($scene_type_ID,'wpunity_yamlmeta_exam3d_pat',true);
    $file_contentA = wpunity_replace_chemistry_exam3D_unity($term_meta_exam3d_chem,$scene_id);

    $fileA = $game_path . '/' . $exam_slug . '.unity';
    $create_fileA = fopen($fileA, "w") or die("Unable to open file!");
    fwrite($create_fileA, $file_contentA);
    fclose($create_fileA);

    $fileEditorBuildSettings = $settings_path . '/EditorBuildSettings.asset';//path of EditorBuildSettings.asset
    $fileApath_forCS = 'Assets/scenes/' . $exam_slug . '.unity';
    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,$fileApath_forCS);//Update the EditorBuildSettings.asset by adding new Scene
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $fileApath_forCS);

}

function wpunity_create_chemistry_lab_unity($scene_post,$scene_type_ID,$scene_id,$gameSlug,$game_path,$settings_path,$handybuilder_file,$scenes_counter,$gameType){
    //DATA of Chemistry Wander Around Scene
    $term_meta_wander_around_chem = get_term_meta($scene_type_ID,'wpunity_yamlmeta_chemistry_pat',true);
    $scene_name = $scene_post->post_name;
    $scene_title = $scene_post->post_title;
    $scene_desc = $scene_post->post_content;

    $featured_image_edu_sprite_id = get_post_thumbnail_id( $scene_id );//The Featured Image ID
    $featured_image_edu_sprite_guid = 'dad02368a81759f4784c7dbe752b05d6';//if there's no Featured Image
    if($featured_image_edu_sprite_id != ''){$featured_image_edu_sprite_guid = wpunity_compile_sprite_upload($featured_image_edu_sprite_id,$gameSlug,$scene_id);}


    $file_contentA = wpunity_replace_chemistry_lab_unity($term_meta_wander_around_chem,$scene_id); //empty energy scene with Avatar!
    $file_contentAb = wpunity_addAssets_chemistry_lab_unity($scene_id);//add objects from json
    //$fileA = $game_path . '/' . $scene_name . '.unity';
    $fileA = $game_path . '/' . 'S_Lab' . '.unity';
    $create_fileA = fopen($fileA, "w") or die("Unable to open file!");
    fwrite($create_fileA, $file_contentA);
    fwrite($create_fileA,$file_contentAb);
    fclose($create_fileA);

    wpunity_compile_append_scene_to_s_selector($scene_id, /*$scene_name*/'S_Lab', $scene_title, $scene_desc, $scene_type_ID,
        $game_path, $scenes_counter, $featured_image_edu_sprite_guid, $gameType);

    $fileEditorBuildSettings = $settings_path . '/EditorBuildSettings.asset';//path of EditorBuildSettings.asset
    $fileApath_forCS = 'Assets/scenes/' . /*$scene_name*/'S_Lab' . '.unity';
    wpunity_append_scenes_in_EditorBuildSettings_dot_asset($fileEditorBuildSettings,$fileApath_forCS);//Update the EditorBuildSettings.asset by adding new Scene
    wpunity_add_in_HandyBuilder_cs($handybuilder_file, null, $fileApath_forCS);

}

function wpunity_addAssets_chemistry_lab_unity($scene_id){
    $scene_json = get_post_meta($scene_id,'wpunity_scene_json_input',true);

    $jsonScene = htmlspecialchars_decode ( $scene_json );
    $sceneJsonARR = json_decode($jsonScene, TRUE);

    $current_fid = 51;
    $allObjectsYAML = '';
    $LF = chr(10) ;// line break

    foreach ($sceneJsonARR['objects'] as $key => $value ) {
        if ($key == 'avatarYawObject') {
            //do something about AVATAR
        } else {
            if ($value['categoryName'] == 'Room') {

                $room_id = $value['assetid'];
                $asset_type = get_the_terms( $room_id, 'wpunity_asset3d_cat' );
                $asset_type_ID = $asset_type[0]->term_id;

                $room_obj = get_post_meta($room_id,'wpunity_asset3d_obj',true);

                $room_yaml = get_term_meta($asset_type_ID,'wpunity_yamlmeta_assetcat_pat',true);
                $room_fid = wpunity_create_fids($current_fid++);
                $room_mesh_fid = wpunity_create_fids($current_fid++); //($room_fid+1)
                $room_mesh_collider_fid = wpunity_create_fids($current_fid++); // ($room_fid+2)
                $room_obj_guid =  wpunity_create_guids('obj', $room_obj);
                $room_position_x = - $value['position'][0]; // x is in the opposite site in unity
                $room_position_y = $value['position'][1];
                $room_position_z = $value['position'][2];
                $room_rotation_x = $value['quaternion'][0];
                $room_rotation_y = $value['quaternion'][1];
                $room_rotation_z = $value['quaternion'][2];
                $room_rotation_w = $value['quaternion'][3];
                $room_scale_x = $value['scale'][0];
                $room_scale_y = $value['scale'][1];
                $room_scale_z = $value['scale'][2];
                $room_title = get_the_title($room_id);

                $room_finalyaml = wpunity_replace_room_unity($room_yaml,$room_fid,$room_mesh_fid,$room_mesh_collider_fid,$room_obj_guid,$room_position_x,$room_position_y,$room_position_z,$room_rotation_x,$room_rotation_y,$room_rotation_z,$room_rotation_w,$room_scale_x,$room_scale_y,$room_scale_z,$room_title);
                $allObjectsYAML = $allObjectsYAML . $LF . $room_finalyaml;
            }

            if ($value['categoryName'] == 'Gate') {

                $gate_id = $value['assetid'];
                $asset_type = get_the_terms( $gate_id, 'wpunity_asset3d_cat' );
                $asset_type_ID = $asset_type[0]->term_id;

                $gate_obj = get_post_meta($gate_id,'wpunity_asset3d_obj',true);

                $gate_yaml = get_term_meta($asset_type_ID,'wpunity_yamlmeta_assetcat_pat',true);
                $gate_fid = wpunity_create_fids($current_fid++);
                $gate_mesh_fid = wpunity_create_fids($current_fid++);//($gate_fid+1)
                $gate_mesh_collider_fid = wpunity_create_fids($current_fid++);//($gate_fid+2)
                $gate_obj_guid = wpunity_create_guids('obj', $gate_obj);
                $gate_position_x = - $value['position'][0]; // x is in the opposite site in unity
                $gate_position_y = $value['position'][1];
                $gate_position_z = $value['position'][2];
                $gate_rotation_x = $value['quaternion'][0];
                $gate_rotation_y = $value['quaternion'][1];
                $gate_rotation_z = $value['quaternion'][2];
                $gate_rotation_w = $value['quaternion'][3];
                $gate_scale_x = $value['scale'][0];
                $gate_scale_y = $value['scale'][1];
                $gate_scale_z = $value['scale'][2];
                $moleculeNamingScene_fid = $value['sceneName_target'];

                $gate_finalyaml = wpunity_replace_gate_unity($gate_yaml,$gate_fid,$gate_mesh_fid,$gate_mesh_collider_fid,$gate_obj_guid,$gate_position_x,$gate_position_y,$gate_position_z,$gate_rotation_x,$gate_rotation_y,$gate_rotation_z,$gate_rotation_w,$gate_scale_x,$gate_scale_y,$gate_scale_z,$moleculeNamingScene_fid);
                $allObjectsYAML = $allObjectsYAML . $LF . $gate_finalyaml;
            }
        }
    }

    //return all objects
    return $allObjectsYAML;
}


//==========================================================================================================================================
//==========================================================================================================================================

function wpunity_replace_mainmenu_chem_unity($term_meta_s_mainmenu,$title_text,$featured_image_sprite_guid,$is_bt_settings_active,$is_help_bt_active,$is_exit_button_active,$is_login_bt_active){
    $file_content_return = str_replace("___[mainmenu_featured_image_sprite]___",$featured_image_sprite_guid,$term_meta_s_mainmenu);
    //$file_content_return = str_replace("___[mainmenu_title_text]___",$title_text,$file_content_return);
    //$file_content_return = str_replace("___[mainmenu_is_bt_settings_active]___",$is_bt_settings_active,$file_content_return);
    //$file_content_return = str_replace("___[mainmenu_is_help_bt_active]___",$is_help_bt_active,$file_content_return);
    //$file_content_return = str_replace("___[mainmenu_is_exit_button_active]___",$is_exit_button_active,$file_content_return);
    //$file_content_return = str_replace("___[mainmenu_is_login_bt_active]___",$is_login_bt_active,$file_content_return);

    return $file_content_return;

}

function wpunity_replace_creditsscene_chem_unity($term_meta_s_credits,$credits_content,$featured_image_sprite_guid,$background_image_sprite_guid){
    $file_content_return = str_replace("___[text_credits_scene]___",$credits_content,$term_meta_s_credits);
    $file_content_return = str_replace("___[img_credits_scene]___",$featured_image_sprite_guid,$file_content_return);
    $file_content_return = str_replace("___[imgbg_credits_scene]___",$background_image_sprite_guid,$file_content_return);

    return $file_content_return;
}

function wpunity_replace_settings_chem_unity($term_meta_s_settings){
    return $term_meta_s_settings;
}

function wpunity_replace_help_chem_unity($term_meta_s_help,$text_help_scene,$img_help_scene_guid,$imgbg_help_scene_guid){
    $file_content_return = str_replace("___[text_help_scene]___",$text_help_scene,$term_meta_s_help);
    $file_content_return = str_replace("___[img_help_scene]___",$img_help_scene_guid,$file_content_return);
    $file_content_return = str_replace("___[imgbg_help_scene]___",$imgbg_help_scene_guid,$file_content_return);

    return $file_content_return;
}

function wpunity_replace_login_chem_unity($term_meta_s_login,$WanderAroundScene_title){
    $file_content_return = str_replace("___[WanderAroundScene]___",$WanderAroundScene_title,$term_meta_s_login);

    return $term_meta_s_login;
}

function wpunity_replace_chemistry_lab_unity($term_meta_wander_around_chem,$scene_id){

    $scene_json = get_post_meta($scene_id,'wpunity_scene_json_input',true);

    $jsonScene = htmlspecialchars_decode ( $scene_json );
    $sceneJsonARR = json_decode($jsonScene, TRUE);

    foreach ($sceneJsonARR['objects'] as $key => $value ) {
        if ($key == 'avatarYawObject') {
            $x_pos = - $value['position'][0]; // x is in the opposite site in unity
            $y_pos = $value['position'][1];
            $z_pos = $value['position'][2];
            $x_player_rot = $value['quaternion_player'][0];
            $y_player_rot = $value['quaternion_player'][1];
            $z_player_rot = $value['quaternion_player'][2];
            $w_player_rot = $value['quaternion_player'][3];
        }
    }
    $file_content_return = str_replace("___[player_position_x]___",$x_pos,$term_meta_wander_around_chem);
    $file_content_return = str_replace("___[player_position_y]___",$y_pos,$file_content_return);
    $file_content_return = str_replace("___[player_position_z]___",$z_pos,$file_content_return);

    $file_content_return = str_replace("___[player_rotation_x]___",$x_player_rot,$file_content_return);
    $file_content_return = str_replace("___[player_rotation_y]___",$y_player_rot,$file_content_return);
    $file_content_return = str_replace("___[player_rotation_z]___",$z_player_rot,$file_content_return);
    $file_content_return = str_replace("___[player_rotation_w]___",$w_player_rot,$file_content_return);

    return $file_content_return;

}

function wpunity_replace_chemistry_exam2D_unity($term_meta_exam2d_chem,$scene_id){


    $file_content_return = str_replace("___[player_position_x]___",$x_pos,$term_meta_exam2d_chem);
    $file_content_return = str_replace("___[player_rotation_z]___",$z_player_rot,$file_content_return);
    $file_content_return = str_replace("___[player_rotation_w]___",$w_player_rot,$file_content_return);

    return $file_content_return;

}

function wpunity_replace_chemistry_exam3D_unity($term_meta_exam3d_chem,$scene_id){


    $file_content_return = str_replace("___[player_position_x]___",$x_pos,$term_meta_exam3d_chem);
    $file_content_return = str_replace("___[player_rotation_z]___",$z_player_rot,$file_content_return);
    $file_content_return = str_replace("___[player_rotation_w]___",$w_player_rot,$file_content_return);

    return $file_content_return;

}

function wpunity_replace_room_unity($room_yaml,$room_fid,$room_mesh_fid,$room_mesh_collider_fid,$room_obj_guid,$room_position_x,$room_position_y,$room_position_z,$room_rotation_x,$room_rotation_y,$room_rotation_z,$room_rotation_w,$room_scale_x,$room_scale_y,$room_scale_z,$room_title){
    $file_content_return = str_replace("___[room_fid]___",$room_fid,$room_yaml);
    $file_content_return = str_replace("___[room_mesh_fid]___",$room_mesh_fid,$file_content_return);
    $file_content_return = str_replace("___[room_mesh_collider_fid]___",$room_mesh_collider_fid,$file_content_return);
    $file_content_return = str_replace("___[room_obj_guid]___",$room_obj_guid,$file_content_return);
    $file_content_return = str_replace("___[room_position_x]___",$room_position_x,$file_content_return);
    $file_content_return = str_replace("___[room_position_y]___",$room_position_y,$file_content_return);
    $file_content_return = str_replace("___[room_position_z]___",$room_position_z,$file_content_return);
    $file_content_return = str_replace("___[room_rotation_x]___",$room_rotation_x,$file_content_return);
    $file_content_return = str_replace("___[room_rotation_y]___",$room_rotation_y,$file_content_return);
    $file_content_return = str_replace("___[room_rotation_z]___",$room_rotation_z,$file_content_return);
    $file_content_return = str_replace("___[room_rotation_w]___",$room_rotation_w,$file_content_return);
    $file_content_return = str_replace("___[room_scale_x]___",$room_scale_x,$file_content_return);
    $file_content_return = str_replace("___[room_scale_y]___",$room_scale_y,$file_content_return);
    $file_content_return = str_replace("___[room_scale_z]___",$room_scale_z,$file_content_return);
    $file_content_return = str_replace("___[room_title]___",$room_title,$file_content_return);

    return $file_content_return;
}

function wpunity_replace_gate_unity($gate_yaml,$gate_fid,$gate_mesh_fid,$gate_mesh_collider_fid,$gate_obj_guid,$gate_position_x,$gate_position_y,$gate_position_z,$gate_rotation_x,$gate_rotation_y,$gate_rotation_z,$gate_rotation_w,$gate_scale_x,$gate_scale_y,$gate_scale_z,$moleculeNamingScene_fid){
    $file_content_return = str_replace("___[gate_fid]___",$gate_fid,$gate_yaml);
    $file_content_return = str_replace("___[gate_mesh_fid]___",$gate_mesh_fid,$file_content_return);
    $file_content_return = str_replace("___[gate_mesh_collider_fid]___",$gate_mesh_collider_fid,$file_content_return);
    $file_content_return = str_replace("___[gate_obj_guid]___",$gate_obj_guid,$file_content_return);
    $file_content_return = str_replace("___[gate_position_x]___",$gate_position_x,$file_content_return);
    $file_content_return = str_replace("___[gate_position_y]___",$gate_position_y,$file_content_return);
    $file_content_return = str_replace("___[gate_position_z]___",$gate_position_z,$file_content_return);
    $file_content_return = str_replace("___[gate_rotation_x]___",$gate_rotation_x,$file_content_return);
    $file_content_return = str_replace("___[gate_rotation_y]___",$gate_rotation_y,$file_content_return);
    $file_content_return = str_replace("___[gate_rotation_z]___",$gate_rotation_z,$file_content_return);
    $file_content_return = str_replace("___[gate_rotation_w]___",$gate_rotation_w,$file_content_return);
    $file_content_return = str_replace("___[gate_scale_x]___",$gate_scale_x,$file_content_return);
    $file_content_return = str_replace("___[gate_scale_y]___",$gate_scale_y,$file_content_return);
    $file_content_return = str_replace("___[gate_scale_z]___",$gate_scale_z,$file_content_return);
    $file_content_return = str_replace("___[moleculeNamingScene_fid]___",$moleculeNamingScene_fid,$file_content_return);

    return $file_content_return;

}

function wpunity_replace_molecule_unity(){}

?>
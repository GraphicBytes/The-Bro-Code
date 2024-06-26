

<form method="post" id="new-topic-form" class="new-topic-form" action="<?php echo $base_url; ?>/new-topic/<?php echo $board_id; ?>/" enctype="multipart/form-data">

  <div class="loading alt topic-submit-loading">
    <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
  </div>


  <textarea maxlength='300' class="topicheader" id="newtopicheader" name="newtopicheader" placeholder="Topic Title"></textarea>

  <div class="video-embed-details-container">
    <div class="video-embed-details">
      <select class="video_type" name="video_type" id="video_type">
          <option value="0">Video Type</option>
          <option value="youtube">YouTube</option>
          <option value="vimeo">Vimeo</option>
      </select>

      <input type="text" id="video_id" name="video_id" class="text-field" placeholder="Video ID, usually found in the URL" disabled>
    </div>

    <div class="video-container-wrap">
      <div class="video-container">

      </div>
    </div>
  </div>





  <div class="gallery-upload-section">
    <div class="gallery-upload-container">
      <div class="galery-upload-box">

        <input type="file" name="upload_gallery[]" id="upload_gallery" multiple="multiple">

        <!-- Drag and Drop container-->
        <div class="gallery-upload-area" id="uploadgallery">
          <div class="loading alt gallery-photo-loading">
            <?php include($php_base_directory . '/includes/loading-alt.php'); ?>
          </div>

          <input type="file" name="file" id="file">
          <input type="hidden" id="newfile" name="newfile" value="1">
          <div class="gallery-drag-drop-outer-dash">
            <div>
              <h4>Click here or drag-and-drop to change your profile photo</h4>
              <p>jpg &amp; png only - 5mb Each Max</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="gallery-preview-container">
      <div class="gallery-preview" data-images="0">

      </div>
    </div>
  </div>


  <textarea  maxlength='10000' class="new-topic-content" id="new-topic-content" name="new-topic-content" placeholder="All yours, Bro!"></textarea>

    <div class="poll-container" data-options='2'>
    <div class="poll-options">
      <input maxlength="300" type="text" id="poll_option_1" name="poll_option_1" class="text-field text-left" placeholder="Option 1">
      <input maxlength="300" type="text" id="poll_option_2" name="poll_option_2" class="text-field border-top text-left" placeholder="Option 2">
      <div class="option-ghost"></div>
      <div class="add-poll-option-button">Add Option</div>
    </div>
  </div>


  <div class="link-container" data-options='1'>
    <div class="poll-options">
      <input maxlength="300" type="text" id="link_1" name="link_1" class="text-field text-left" placeholder="Link 1 (include https://)">
      <div class="link-ghost"></div>
      <div class="add-link-option-button">Add Link</div>
    </div>
  </div>


  <span class="meta">
    <span class="meta-left">

      <div class="checkbox-container">
        <span class="checkbox-tool-tip members-only">
          Keep the more mature content members only
          <svg class="tooltip-arrow members-only" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z"/>
          </svg>
        </span>
        <input type="checkbox" class="checkbox" id="membersonly" name="membersonly">
        <label class="checkbox-label" for="membersonly">MEMBERS ONLY</label>
      </div>
      <div class="checkbox-container">
        <span class="checkbox-tool-tip poll">
          Don't bitch at us if your Bros don't agree
          <svg class="tooltip-arrow poll" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z"/>
          </svg>
        </span>
        <input type="checkbox" class="checkbox" id="poll" name="poll">
        <label class="checkbox-label" for="poll">POLL</label>
      </div>
      <div class="checkbox-container">
        <span class="checkbox-tool-tip images">
          Add upto 32 images to this post (5MB MAX EACH)
          <svg class="tooltip-arrow images" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z"/>
          </svg>
        </span>
        <input type="checkbox" class="checkbox" id="imagegallery" name="imagegallery">
        <label class="checkbox-label" for="imagegallery">IMAGE/S</label>
      </div>
      <div class="checkbox-container">
        <span class="checkbox-tool-tip video">
          Embed a video to the top of this post
          <svg class="tooltip-arrow video" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z"/>
          </svg>
        </span>
        <input type="checkbox" class="checkbox" id="video" name="video">
        <label class="checkbox-label" for="video">VIDEO</label>
      </div>
      <div class="checkbox-container">
        <span class="checkbox-tool-tip video">
          Include upto 5 links with your post
          <svg class="tooltip-arrow video" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z"/>
          </svg>
        </span>
        <input type="checkbox" class="checkbox" id="links" name="links">
        <label class="checkbox-label" for="links">LINKS</label>
      </div>


    </span>
    <span class="meta-right">

      <span class="meta-link-no-hover header_count">0/300</span>
      <span class="meta-link-no-hover body_count">0/10000</span>

      <input class="comment-submit submittopic" id="submittopic" type="submit" value="POST" disabled />
    </span>
  </span>

</form>



<?php include($php_base_directory . '/sections/boards/includes/editor-js.php'); ?>





<?php // ?>

<div class="modal customModal fade" id="<?php echo ( isset($modal_id) ) ? $modal_id:""?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo ( isset($modal_id) ) ? $modal_id:""?>_parent<?php echo $ctr?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="modaltitleDiv text-center">
      		<h5 class="modal-title"><?php echo ( isset($modal_title) ) ? $modal_title:""?></h5>
      	</div>

      	<div class="modalText">
      		<div class="text"><?php echo ( isset($modal_text) ) ? $modal_text:""?></div>
      		<?php if ($buttons) { ?>
					<div class="cta-buttons buttondiv text-center">
						<?php foreach ($buttons as $b) { 
							$btn = $b['button'];
							$btnName = (isset($btn['title']) && $btn['title']) ? $btn['title'] : '';
							$btnLink = (isset($btn['url']) && $btn['url']) ? $btn['url'] : '';
							$btnTarget = (isset($btn['target']) && $btn['target']) ? $btn['target'] : '_self';
							if($btnName && $btnLink) { ?>
							<a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="btn-sm xs"><span><?php echo $btnName ?></span></a>
							<?php } ?>
						<?php } ?>
					</div>
					<?php } ?>
      	</div>
      </div>
    </div>
  </div>
</div>
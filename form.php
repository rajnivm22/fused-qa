<form id="nw_post" name="question-form" method="post" action=""  enctype="multipart/form-data">
	        <!-- post name -->

                    <div class="control-group">
                        <div class="input-prepend">
                        <span class="add-on">Title</span>
                                <input type="text" id="title" value=""  name="title"  class="input-xxlarge"  placeholder="Title" />
                        </div>
                    </div>
         
                  <div class="control-group">
                        <div class="input-prepend">
                            <span class="add-on">Tags</span>
                                <input type="text" id="q-tags" value=""  name="tags"  class="input-xxlarge" placeholder="Tags" />
			  </div>
                  </div>
         
         
                 <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on">Category</span>
                            <?php wp_dropdown_categories( 'tab_index=10&taxonomy=category&hide_empty=0' ); ?>
                    </div>
                 </div>
         
 		<!-- post Content -->
		 <div class="control-group">
                      <div class="controls">
                          <textarea placeholder=" Please Enter Description Here" aria-required="true" rows="9" name="description" class="span11" id="comment"></textarea>
                      </div>
                 </div>
                
                
                <!---Submit button----->
                 <div class="control-group">
                      <div class="controls">
	                   <input type="submit" value="Post Your Question"  class="btn" id="submit" name="submit" />
                      </div>
                 </div>
                <input type="hidden" name="action" value="question-form" />
	         <?php   wp_nonce_field('question-form');?>
</form>


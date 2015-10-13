<div class="col-md-3 col-sm-4 product-sidebar">
<?php if(is_active_sidebar('woo-sidebar'  )): ?>
    <?php dynamic_sidebar('woo-sidebar' ); ?>
<?php else: ?>
<?php endif; ?>
              <!--   <aside class="widget service-category-widget">
                  <h3>category menu</h3>
                  <ul>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Bathroom Cleaners" href="#">BATHROOM CLEANERS</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Equipment" href="#">Equipment</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Laundry & Linen" href="#">Laundry & linen</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Mopping Equipment" href="#">mops / mopping equipment</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Paper Product" href="#">paper products</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Trash Receptacles" href="#">trash receptacles / carts</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Window Washing" href="#">window washing</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Chemicals" href="#">chemicals</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Vacuum Cleaners" href="#">vacuum cleaners</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Cleaning Tools" href="#">CLEANING TOOLS</a></li>
                      <li><i class="fa fa-long-arrow-right"></i><a title="Brooms & Hand Pads" href="#">Brooms & Hand Pads</a></li>
                  </ul>
              </aside>

              <aside class="widget widget_search">
                  <h3>SEARCH PRODUCT</h3>
                  <form method="get" action="<?=esc_url( home_url( '/' ) )?>" role="search" class="search">
                      <input type="text" required="" class="form-control" placeholder="FIND HERE..." id="s" name="s" value="<?php echo get_search_query(); ?>" >
                      <input type="hidden" name="post_type" value="product" />
                      <span class="search-icon input-group-btn"><button type="submit" class="btn btn-xlg"></button></span>
                  </form>


              </aside>

              <aside class="widget price-filter-widget">
                  <h3>Price Filter</h3>
                  <div id="slider-range"></div>
                  <a title="filter" href="#" class="filter">Filter</a>
                  <div class="price-input">
                      <label>Price:</label>
                      <span id="amount"></span>
                      <label> - </label>
                      <span id="amount2"></span>
                  </div>
              </aside>

              <aside class="widget add-widget">
                  <a title="Add Banner" href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/product/add-banner.jpg" alt="add banner" /></a>
              </aside> -->
            </div><!-- col-md-3 /- -->
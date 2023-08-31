<?php
overall_header();
global $config;
?>
<link type="text/css" href="<?php _esc(TEMPLATE_URL);?>/service_fragments/css/gig_detail.css" rel="stylesheet" />
<!-- Intro Banner
================================================== -->
<!-- add class "disable-gradient" to enable consistent background overlay -->
<div class="intro-banner <?php _esc($config['banner_overlay']);?>"
    data-background-image="<?php _esc($config['site_url']);?>storage/banner/<?php _esc($config['home_banner']);?>">
    <!-- Transparent Header Spacer -->
    <div class="transparent-header-spacer"></div>
    <div class="container">
        <!-- Intro Headline -->
        <div class="row">
            <div class="col-md-12">
                <div class="banner-headline">
                    <h3>
                        <strong><?php _e("Hire the best freelancers for any job, online.") ?></strong>
                        <br>
                        <span><?php _e("Work with the best freelance talent from around the world on our secure and cost-effective platform.") ?></span>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row">
            <div class="col-md-12">
                <form autocomplete="off" method="get" action="<?php url("SEARCH_PROJECTS") ?>" accept-charset="UTF-8">
                    <div class="intro-banner-search-form margin-top-95">
                        <!-- Search Field -->
                        <div class="intro-search-field">
                            <label for="intro-keywords"
                                class="field-title ripple-effect"><?php _e("Find Work") ?></label>
                            <input id="intro-keywords" type="text" class="qucikad-ajaxsearch-input"
                                placeholder="<?php _e("Project Title or Keywords") ?>" data-prev-value="0"
                                data-noresult="<?php _e("More Results For") ?>">
                            <i class="qucikad-ajaxsearch-close fa fa-times-circle" aria-hidden="true"
                                style="display: none;"></i>
                            <div id="qucikad-ajaxsearch-dropdown" size="0" tabindex="0">
                                <ul>
                                    <?php
                                foreach($category as $cat){
                                    ?>
                                    <li class="qucikad-ajaxsearch-li-cats" data-catid="<?php echo $cat['slug']; ?>">
                                        <?php
                                        echo '<i class="qucikad-as-caticon '.$cat['icon'].'"></i>';
                                        ?>
                                        <span class="qucikad-as-cat"><?php echo $cat['name']; ?></span>
                                    </li>
                                    <?php
                                }
                                ?>
                                </ul>

                                <div style="display:none" id="def-cats">

                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="intro-search-button">
                            <button class="button ripple-effect"><?php _e("Search") ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="row">
            <div class="col-md-12">
                <ul class="intro-stats margin-top-45 hide-under-992px">
                    <li>
                        <strong class="counter"><?php _esc($total_projects);?></strong>
                        <span><?php _e("Projects") ?></span>
                    </li>
                    <li>
                        <strong class="counter"><?php _esc($total_jobs);?></strong>
                        <span><?php _e("Jobs Posted") ?></span>
                    </li>
                    <li>
                        <strong class="counter"><?php _esc($total_freelancer);?></strong>
                        <span><?php _e("Freelancers") ?></span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Content
================================================== -->
<!-- Category Boxes -->
<!-- Category Boxes -->
<div class="section gray padding-top-65 padding-bottom-45">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-headline centered margin-bottom-15">
                    <h3><?php _e("Project Categories") ?></h3>
                </div>
                <div class="categories-container">
                    <?php foreach($category as $cat){ ?>
                    <a href="<?php echo $cat['link']; ?>" class="category-box">
                        <div class="category-box-icon">
                            <?php
                                echo '<div class="category-icon"><i class="'.$cat['icon'].'"></i></div>';
                            ?>
                        </div>
                        <div class="category-box-counter"><?php echo $cat['main_ads_count']; ?></div>
                        <div class="category-box-content">
                            <h3><?php echo $cat['name']; ?> <small>(<?php echo $cat['main_ads_count']; ?>)</small></h3>
                        </div>
                        <div class="category-box-arrow">
                            <i class="fa fa-chevron-right"></i>
                        </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Category Boxes / End -->
<!--- AD Banner -->
<div style="display: flex; justify-content: center;align-items: center;">
    <?php foreach($itemb as $banner){ ?>
    <a style="display: flex; justify-content: center;align-items: center;" href="<?php _esc($banner['url']); ?>">
        <img class="mySlides w3-animate-fading" src="storage/banner_advertise/<?php _esc($banner['file']); ?> "
            style="width:80%">
    </a>
    <?php } ?>
</div>
<!--- / AD Banner -->
<!-- Recommed Projects -->
<?php if($is_login){ ?>
<div class="section margin-top-45 padding-top-65 padding-bottom-75">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <?php
                    $user_id = $_SESSION['user']['id'];
                    $data = ORM::for_table('ql_user')->where_equal('id', $user_id)->find_many();
                    foreach($data as $d){
                
                        if($d['subcategory']){
                            $sub_category = $d['subcategory'];
                        } 
                        if($d['category']){
                            $category = $d['category'];
                        }
                    }
                    $data1 = ORM::for_table('ql_catagory_main')->where_equal('cat_id', $category)->find_many();
                    $data2 = ORM::for_table('ql_catagory_sub')->where_equal('sub_cat_id', $sub_category)->find_many();
                    foreach($data1 as $d1){
                        $category = $d1['slug'];
                    }
                    foreach($data2 as $d2){
                        $sub_category = $d2['slug'];
                    }
                ?>

                <!-- Section Headline -->
                <div class="section-headline margin-top-0 margin-bottom-35">
                    <h3>Dự án đề xuất</h3>
                    <a href="projects/<?php echo $category.'/'.$sub_category;?>"
                        class="headline-link"><?php _e("Browse All Projects") ?></a>
                </div>

                <!-- Jobs Container -->
                <div class="tasks-list-container compact-list margin-top-35">
                    <?php
                    foreach($item4 as $project){
                    ?>
                    <!-- Task -->
                    <a href="<?php _esc($project['link']);?>"
                        class="task-listing <?php if($project['highlight']){ echo 'highlight';} ?>">
                        <!-- Job Listing Details -->
                        <div class="task-listing-details">
                            <!-- Details -->
                            <div class="task-listing-description">
                                <h3 class="task-listing-title"><?php _esc($project['product_name']);?></h3>
                                <?php if($project['featured'] == 1){ ?>
                                <div class="dashboard-status-button blue"> <?php _e("Featured") ?></div>
                                <?php }
                                if($project['urgent'] == 1){ ?>
                                <div class="dashboard-status-button yellow"> <?php _e("Urgent") ?></div>
                                <?php } ?>
                                <ul class="task-icons">
                                    <li><i class="icon-material-outline-gavel"></i>
                                        <?php _esc($project['bids_count']);?> Phiếu thầu</li>
                                    <li><i class="icon-material-outline-account-balance-wallet"></i>
                                        <?php _esc($project['avg_bid']);?> <?php _e("Avg bid") ?></li>
                                    <li><i class="icon-material-outline-access-time"></i>
                                        <?php _esc($project['created_at']);?></li>
                                </ul>
                                <div class="task-tags margin-top-15">
                                    <?php _esc($project['skills']);?>
                                </div>
                            </div>
                        </div>
                        <div class="task-listing-bid">
                            <div class="task-listing-bid-inner">
                                <div class="task-offers">
                                    <strong><?php _esc($project['salary_min']);?> -
                                        <?php _esc($project['salary_max']);?> </strong>
                                    <span><?php _esc($project['salary_type']);?></span>
                                </div>
                                <span class="button button-sliding-icon ripple-effect"><?php _e("Bid Now") ?> <i
                                        class="icon-material-outline-arrow-right-alt"></i></span>
                            </div>
                        </div>
                    </a>
                    <?php } ?>

                </div>
                <!-- Jobs Container / End -->

            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Recommend Projects / End -->

<!-- Latest Projects -->
<div class="section margin-top-45 padding-top-65 padding-bottom-75">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">

                <!-- Section Headline -->
                <div class="section-headline margin-top-0 margin-bottom-35">
                    <h3><?php _e("Latest Projects") ?></h3>
                    <a href="<?php url("SEARCH_PROJECTS") ?>"
                        class="headline-link"><?php _e("Browse All Projects") ?></a>
                </div>

                <!-- Jobs Container -->
                <div class="tasks-list-container compact-list margin-top-35">
                    <?php
                    foreach($item2 as $project){
                    ?>
                    <!-- Task -->
                    <a href="<?php _esc($project['link']);?>"
                        class="task-listing <?php if($project['highlight']){ echo 'highlight';} ?>">
                        <!-- Job Listing Details -->
                        <div class="task-listing-details">
                            <!-- Details -->
                            <div class="task-listing-description">
                                <h3 class="task-listing-title"><?php _esc($project['product_name']);?></h3>
                                <?php if($project['featured'] == 1){ ?>
                                <div class="dashboard-status-button blue"> <?php _e("Featured") ?></div>
                                <?php }
                                if($project['urgent'] == 1){ ?>
                                <div class="dashboard-status-button yellow"> <?php _e("Urgent") ?></div>
                                <?php } ?>
                                <ul class="task-icons">
                                    <li><i class="icon-material-outline-gavel"></i>
                                        <?php _esc($project['bids_count']);?> Phiếu thầu</li>
                                    <li><i class="icon-material-outline-account-balance-wallet"></i>
                                        <?php _esc($project['avg_bid']);?> <?php _e("Avg bid") ?></li>
                                    <li><i class="icon-material-outline-access-time"></i>
                                        <?php _esc($project['created_at']);?></li>
                                </ul>
                                <div class="task-tags margin-top-15">
                                    <?php _esc($project['skills']);?>
                                </div>
                            </div>
                        </div>
                        <div class="task-listing-bid">
                            <div class="task-listing-bid-inner">
                                <div class="task-offers">
                                    <strong><?php _esc($project['salary_min']);?> -
                                        <?php _esc($project['salary_max']);?> </strong>
                                    <span><?php _esc($project['salary_type']);?></span>
                                </div>
                                <span class="button button-sliding-icon ripple-effect"><?php _e("Bid Now") ?> <i
                                        class="icon-material-outline-arrow-right-alt"></i></span>
                            </div>
                        </div>
                    </a>
                    <?php } ?>

                </div>
                <!-- Jobs Container / End -->

            </div>
        </div>
    </div>
</div>
<!-- Latest Projects / End -->

<!-- Feature Project -->
<div class="section margin-top-45 padding-top-65 padding-bottom-75">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">

                <!-- Section Headline -->
                <div class="section-headline margin-top-0 margin-bottom-35">
                    <h3><?php _e("Featured Project") ?></h3>
                    <a href="<?php url("SEARCH_PROJECTS") ?>"
                        class="headline-link"><?php _e("Browse All Projects") ?></a>
                </div>

                <!-- Jobs Container -->
                <div class="tasks-list-container compact-list margin-top-35">
                    <?php
                    foreach($item2 as $project){
                    ?>
                    <!-- Task -->
                    <a href="<?php _esc($project['link']);?>"
                        class="task-listing <?php if($project['highlight']){ echo 'highlight';} ?>">
                        <!-- Job Listing Details -->
                        <div class="task-listing-details">
                            <!-- Details -->
                            <div class="task-listing-description">
                                <h3 class="task-listing-title"><?php _esc($project['product_name']);?></h3>
                                <?php if($project['featured'] == 1){ ?>
                                <div class="dashboard-status-button blue"> <?php _e("Featured") ?></div>
                                <?php }
                                if($project['urgent'] == 1){ ?>
                                <div class="dashboard-status-button yellow"> <?php _e("Urgent") ?></div>
                                <?php } ?>
                                <ul class="task-icons">
                                    <li><i class="icon-material-outline-gavel"></i>
                                        <?php _esc($project['bids_count']);?> Phiếu thầu</li>
                                    <li><i class="icon-material-outline-account-balance-wallet"></i>
                                        <?php _e("Avg bid") ?>: <?php _esc($project['avg_bid']);?></li>
                                    <li><i class="icon-material-outline-access-time"></i>
                                        <?php _esc($project['created_at']);?></li>
                                </ul>
                                <div class="task-tags margin-top-15">
                                    <?php _esc($project['skills']);?>
                                </div>
                            </div>
                        </div>
                        <div class="task-listing-bid">
                            <div class="task-listing-bid-inner">
                                <div class="task-offers">
                                    <strong><?php _esc($project['salary_min']);?> -
                                        <?php _esc($project['salary_max']);?> </strong>
                                    <span><?php _esc($project['salary_type']);?></span>
                                </div>
                                <span class="button button-sliding-icon ripple-effect"><?php _e("Bid Now") ?> <i
                                        class="icon-material-outline-arrow-right-alt"></i></span>
                            </div>
                        </div>
                    </a>
                    <?php } ?>

                </div>
                <!-- Jobs Container / End -->

            </div>
        </div>
    </div>
</div>
<!-- LFeature Project / End -->

<!-- Highest Rated Freelancers -->
<div class="section padding-top-65 padding-bottom-70 full-width-carousel-fix">
    <div class="container">
        <div class="row">

            <div class="col-xl-12">
                <!-- Section Headline -->
                <div class="section-headline margin-top-0 margin-bottom-25">
                    <h3><?php _e('Highest Rated Freelancers')?></h3>
                    <a href="<?php url("FREELANCERS") ?>" class="headline-link"><?php _e('Browse All Freelancers')?></a>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="default-slick-carousel freelancers-container freelancers-grid-layout">

                    <!--Freelancer -->
                    <?php
                    foreach($freelancers as $freelancer){
                    ?>
                    <div class="freelancer">
                        <!-- Overview -->
                        <div class="freelancer-overview">
                            <div class="freelancer-overview-inner">
                                <!-- Avatar -->
                                <div class="freelancer-avatar">
                                    <div class="verified-badge"></div>
                                    <a href="<?php url("PROFILE") ?>/<?php _esc($freelancer['username']) ?>">
                                        <img src="<?php _esc($config['site_url']);?>storage/profile/<?php _esc($freelancer['image']) ?>"
                                            alt="<?php _esc($freelancer['name']) ?>">
                                    </a>
                                </div>

                                <!-- Name -->
                                <div class="freelancer-name">
                                    <h4><a href="<?php url("PROFILE") ?>/<?php _esc($freelancer['username']) ?>"><?php _esc($freelancer['name']) ?>
                                            <div class="flag flag-vn">
                                        </a></h4>
                                    <?php
                                    if($freelancer['category'] != ""){
                                        echo "<span>";
                                        _esc($freelancer['category']);
                                        if($freelancer['subcategory'] != ""){
                                            echo " / ";
                                            _esc($freelancer['subcategory']);
                                        }
                                        echo "</span>";
                                    }else {
                                        echo "<p>";
                                        echo "</p>";
                                    }
                                    ?>
                                </div>
                                <!-- Rating -->
                                <div class="freelancer-rating">
                                    <div class="star-rating" data-rating="<?php _esc($freelancer['rating']) ?>"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Details -->
                        <div class="freelancer-details">
                            <div class="freelancer-details-list">
                                <ul style="text-align: center;">
                                    <li><?php _e("Won Bid") ?>
                                        <strong><?php _esc($freelancer['win_project']) ?></strong>
                                    </li>
                                </ul>
                            </div>
                            <a href="<?php url("PROFILE") ?>/<?php _esc($freelancer['username']) ?>"
                                class="button button-sliding-icon ripple-effect"><?php _e("View Profile") ?> <i
                                    class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- Freelancer / End -->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Highest Rated Freelancers / End-->

<?php if($config['show_membershipplan_home']){ ?>
<!-- Membership Plans -->
<div class="section gray padding-top-60 padding-bottom-75">
    <div class="container">
        <div class="row">

            <div class="col-xl-12">
                <!-- Section Headline -->
                <div class="section-headline centered margin-top-0">
                    <h3><?php _e("Membership Plan") ?></h3>
                </div>
            </div>


            <div class="col-xl-12">
                <form name="form1" method="post" action="<?php url("MEMBERSHIP") ?>">
                    <div class="billing-cycle-radios margin-bottom-70">
                        <?php
                        if($total_monthly){
                        ?>
                        <div class="radio billed-monthly-radio">
                            <input id="radio-monthly" name="billed-type" type="radio" value="monthly" checked="">
                            <label for="radio-monthly"><span class="radio-label"></span> <?php _e("Monthly") ?></label>
                        </div>
                        <?php
                        }
                        if($total_annual){
                        ?>
                        <div class="radio billed-yearly-radio">
                            <input id="radio-yearly" name="billed-type" type="radio" value="yearly">
                            <label for="radio-yearly"><span class="radio-label"></span> <?php _e("Yearly") ?></label>
                        </div>
                        <?php
                        }
                        if($total_lifetime){
                        ?>
                        <div class="radio billed-lifetime-radio">
                            <input id="radio-lifetime" name="billed-type" type="radio" value="lifetime">
                            <label for="radio-lifetime"><span class="radio-label"></span>
                                <?php _e("Lifetime") ?></label>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- Pricing Plans Container -->
                    <div class="pricing-plans-container">
                        <?php
                        foreach($sub_types as $plan){
                        ?>
                        <!-- Plan -->
                        <div
                            class='pricing-plan <?php if(isset($plan['recommended']) && $plan['recommended']=="yes"){ echo 'recommended';} ?>'>

                            <?php
                                if(isset($plan['recommended']) && $plan['recommended']=="yes"){
                                    echo '<div class="recommended-badge">'.__("Recommended").'</div> ';
                                }
                                ?>
                            <h3><?php _esc($plan['title'])?></h3>
                            <?php
                                if($plan['id']=="free" || $plan['id']=="trial"){
                                    ?>
                            <div class="pricing-plan-label"><strong>
                                    <?php
                                            if($plan['id']=="free")
                                                _e("Free");
                                            else
                                                _e("Trial");
                                            ?>
                                </strong></div>

                            <?php
                                }
                                else{
                                    if($total_monthly != 0)
                                        echo '<div class="pricing-plan-label billed-monthly-label"><strong>'._esc($plan['monthly_price'],false).'</strong>/ '.__("Monthly").'</div>';
                                    if($total_annual != 0)
                                        echo '<div class="pricing-plan-label billed-yearly-label"><strong>'._esc($plan['annual_price'],false).'</strong>/ '.__("Yearly").'</div>';
                                    if($total_lifetime != 0)
                                        echo '<div class="pricing-plan-label billed-lifetime-label"><strong>'._esc($plan['lifetime_price'],false).'</strong>/ '.__("Lifetime").'</div>';
                                }
                                ?>

                            <div class="pricing-plan-features">
                                <strong><?php _e("Features of") ?> <?php _esc($plan['title'])?></strong>
                                <ul>
                                    <li><?php _e("Project Fee") ?> <?php _esc($plan['freelancer_commission'])?>%</li>
                                    <li><?php if($plan['bids'] != 999) {_esc($plan['bids'])._e(" "). _e("Bids");}else {_esc("Không giới hạn")._e(" ")._e("Bids");} ?></li>
                                    <li><?php if($plan['skills'] != 999) {_esc($plan['skills'])._e(" "). _e("Skills");}else {_esc("Không giới hạn")._e(" ")._e("Skills");} ?></li>
                                </ul>
                            </div>
                            <?php
                                if($plan['Selected'] == 0){
                                    echo '<button type="submit" class="button full-width margin-top-20 ripple-effect" name="upgrade" value="'._esc($plan['id'],false).'">'.__("Upgrade").'</button>';
                                }
                                if($plan['Selected'] == 1){
                                    echo '<a href="javascript:void(0);" class="button full-width margin-top-20 ripple-effect">'.__("Current Plan").'</a>';
                                }
                                ?>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Membership Plans / End-->
<?php } ?>

<!-- Testimonials -->
<?php if($config['testimonials_enable'] && $config['show_testimonials_home']){ ?>
<div class="section padding-top-65 padding-bottom-55">

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- Section Headline -->
                <div class="section-headline centered margin-top-0 margin-bottom-5">
                    <h3><?php _e("Testimonials") ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Carousel -->
    <div class="fullwidth-carousel-container margin-top-20">
        <div class="testimonial-carousel testimonials">

            <!-- Item -->
            <?php
            foreach($testimonials as $testimonial){
            ?>
            <div class="fw-carousel-review">
                <div class="testimonial-box">
                    <div class="testimonial-avatar">
                        <img src="<?php _esc($config['site_url']);?>storage/testimonials/<?php _esc($testimonial['image']) ?>"
                            alt="<?php _esc($testimonial['name']) ?>">
                    </div>
                    <div class="testimonial-author">
                        <h4><?php _esc($testimonial['name']) ?></h4>
                        <span><?php _esc($testimonial['designation']) ?></span>
                    </div>
                    <div class="testimonial"><?php _esc($testimonial['content']) ?></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Categories Carousel / End -->

</div>
<?php } ?>
<!-- Testimonials / End -->

<!-- Counters -->
<div class="section gray padding-top-70 padding-bottom-75">
    <div class="container">
        <div class="row">

            <div class="col-xl-12">
                <div class="counters-container">

                    <!-- Counter -->
                    <div class="single-counter">
                        <i class="icon-line-awesome-legal"></i>
                        <div class="counter-inner">
                            <h3><span class="counter"><?php _esc($total_projects);?></span></h3>
                            <span class="counter-title"><?php _e("Projects Posted") ?></span>
                        </div>
                    </div>
                    <!-- Counter -->
                    <div class="single-counter">
                        <i class="icon-line-awesome-suitcase"></i>
                        <div class="counter-inner">
                            <h3><span class="counter"><?php _esc($total_jobs);?></span></h3>
                            <span class="counter-title"><?php _e("Jobs Posted") ?></span>
                        </div>
                    </div>
                    <!-- Counter -->
                    <div class="single-counter">
                        <i class="icon-line-awesome-user"></i>
                        <div class="counter-inner">
                            <h3><span class="counter"><?php _esc($total_freelancer);?></span></h3>
                            <span class="counter-title"><?php _e("Freelancers") ?></span>
                        </div>
                    </div>
                    <!-- Counter -->
                    <div class="single-counter">
                        <i class="icon-line-awesome-trophy"></i>
                        <div class="counter-inner">
                            <h3><span class="counter"><?php _esc($community_earning);?></span><?php _esc($config['currency_sign']);?></h3>
                            <span class="counter-title"><?php _e("Community Earnings") ?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Counters / End -->

<!-- Recent Blog Posts -->
<?php if($config['blog_enable'] && $config['show_blog_home']){ ?>
<div class="section padding-top-65 padding-bottom-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">

                <!-- Section Headline -->
                <div class="section-headline margin-top-0 margin-bottom-45">
                    <h3><?php _e("Recent Blog") ?></h3>
                    <a href="<?php url("BLOG") ?>" class="headline-link"><?php _e('View Blog')?></a>
                </div>

                <div class="row">
                    <!-- Blog Post Item -->
                    <?php
                    foreach($recent_blog as $blog){
                        ?>
                    <div class="col-xl-4">
                        <a href="<?php _esc($blog['link']) ?>" class="blog-compact-item-container">
                            <div class="blog-compact-item">
                                <img src="<?php _esc($config['site_url']);?>storage/blog/<?php _esc($blog['image']) ?>"
                                    alt="{RECENT_BLOG.title}">
                                <span class="blog-item-tag"><?php _esc($blog['author']) ?></span>
                                <div class="blog-compact-item-content">
                                    <ul class="blog-post-tags">
                                        <li><?php _esc($blog['created_at']) ?></li>
                                    </ul>
                                    <h3><?php _esc($blog['title']) ?></h3>
                                    <p><?php _esc($blog['description']) ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <!-- Blog post Item / End -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Recent Blog Posts / End -->
<div class="hidden-xs jas-sale-pop flex pf middle-xs slideUp"><a href="#" class="jas-sale-pop-img mr__20"><img
src="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_admin_logo']?>" alt="Chào mừng bạn tới trang tìm kiếm việc làm TopLancer"></a>
    <div class="jas-sale-pop-content">
        <h3 class="mg__0 mt__5 mb__5 fs__18"><a href="#"
                title="Chào mừng bạn tới trang tìm kiếm việc làm TopLancer">Chào mừng bạn tới trang tìm kiếm việc làm
                TopLancer</a></h3><span class="fs__12 jas-sale-pop-timeago">Hãy tìm kiếm một số thứ trong website của
            chúng tôi.</span>
    </div><span class="pe-7s-close pa fs__20"></span>
</div>
<?php if($config['show_partner_logo_home']){ ?>
<div class="section gray border-top padding-top-45 padding-bottom-45">
    <!-- Logo Carousel -->
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- Carousel -->
                <div class="col-md-12">
                    <div class="logo-carousel">
                        <?php
                        $dir = ROOTPATH.'/storage/partner/';
                        $i = 0;
                        foreach (glob($dir . '*') as $path) {
                            ?>
                        <div class="carousel-item">
                            <img src="<?php _esc($config['site_url']);?>storage/partner/<?php _esc(basename($path))?>">
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- Carousel / End -->
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script>
var transparent_header = "<?php _esc($config['transparent_header'])?>";
$(document).ready(function() {
    if (transparent_header != '0') {
        $("#wrapper").addClass('wrapper-with-transparent-header');
        $("#header-container").addClass('transparent-header');
    }
});
</script>
<script type="text/javascript">
$(document).ready(function($) {
    if ($(window).width() >= 768) {
        SalesPop();
    }
});

function fisherYates(myArray) {
    var i = myArray.length,
        j, temp;
    if (i === 0) return false;
    while (--i) {
        j = Math.floor(Math.random() * (i + 1));
        temp = myArray[i];
        myArray[i] = myArray[j];
        myArray[j] = temp;
    }
}
var collection = new Array();

<?php
$count = 1;
$myArray = array('1 phút', '2 phút', '3 phút', '4 phút', '5 phút', '6 phút', '7 phút',
'8 phút', '9 phút', '10 phút', '11 phút', '12 phút', '13 phút', '14 phút',
'15 phút', '16 phút', '17 phút', '18 phút', '19 phút', '20 phút', '21 phút',
'22 phút', '23 phút', '24 phút', '25 phút', '26 phút', '27 phút', '28 phút',
'29 phút', '30 phút', '31 phút', '32 phút', '33 phút', '34 phút', '35 phút',
'36 phút', '37 phút', '38 phút', '39 phút', '40 phút', '41 phút', '42 phút',
'43 phút', '44 phút', '45 phút', '46 phút', '47 phút', '48 phút', '49 phút',
'50 phút', '51 phút', '52 phút', '53 phút', '54 phút', '55 phút', '56 phút',
'57 phút', '58 phút', '59 phút');
?>
<?php foreach($items as $item) {?>
collection[<?php echo $count; ?>] = "<a href='<?php echo $item['link'];?>' class='jas-sale-pop-img mr__20'>" +
    "<img src='storage/profile/<?php echo $item['user_image'];?>' alt='Dự án <?php echo $item['product_name'];?>'/>" +
    "</a>" +
    "<div class='jas-sale-pop-content'>"
    //+                                    "<h4 class='fs__12 fwm mg__0'>Sản phẩm</h4>"
    +
    "<h3 class='mg__0 mt__5 mb__5 fs__18'>" +
    "<a href='<?php echo $item['link'];?>' title='<?php echo $item['product_name'];?>'>Dự án <?php echo $item['product_name'];?></a>" +
    "</h3>" +
    "<span class='fs__12 jas-sale-pop-timeago'>Freelancer - <?php echo $item['fullname'];?> vừa nhận dự án này cách đây <?php echo $randomElement = $myArray[array_rand($myArray)];?>.</span>" +
    "</div>" +
    "<span class='pe-7s-close pa fs__20'></span>";
<?php $count++; ?>
<?php } ?>

fisherYates(collection);

function SalesPop() {
    if ($('.jas-sale-pop').length < 0)
        return;
    setInterval(function() {
        $('.jas-sale-pop').fadeIn(function() {
            $(this).removeClass('slideUp');
        }).delay(5000).fadeIn(function() {
            randomProduct = Math.floor(Math.random() * collection.length),
                randomShowP = collection[randomProduct],
                $(".jas-sale-pop").html(randomShowP);
            $(this).addClass('slideUp');
            $('.pe-7s-close').on('click', function() {
                $('.jas-sale-pop').remove();
            });
        }).delay(6000);
    }, 6000);
}
</script>
<style>
.jas-sale-pop.middle-xs {
    -webkit-box-align: center;
    -ms-flex-align: center
}

.jas-sale-pop.flex {
    box-sizing: border-box;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex
}

.as-sale-pop.middle-xs {
    -webkit-box-align: center;
    -ms-flex-align: center;
}

.jas-sale-pop {
    background: #fff;
    bottom: -100%;
    left: 20px;
    right: auto;
    padding: 10px 30px 10px 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
    border-radius: 3px;
    opacity: 0;
    visibility: hidden;
    transition: all 2s;
    z-index: 100;
    position: fixed
}

@media (min-width: 992px) {
    .jas-sale-pop.slideUp {
        bottom: 20px
    }
}

@media (min-width: 320px) and (max-width: 991px) {
    .jas-sale-pop.slideUp {
        bottom: 60px
    }
}

@media (max-width: 480px) {
    .jas-sale-pop {
        left: 10px;
        right: 10px;
        max-width: 300px
    }

    .jas-sale-pop .jas-sale-pop-content {
        max-width: 180px
    }
}

.jas-sale-pop .jas-sale-pop-img {
    margin-right: 10px;
    width: 70px;
    float: left
}

.jas-sale-pop .jas-sale-pop-img img {
    max-height: 70px !important
}

.jas-sale-pop .jas-sale-pop-content {
    width: calc(100% - 80px);
    float: left;
    display: block
}

.jas-sale-pop h4 {
    color: #000;
    margin: 0;
    font-size: 1em;
    font-weight: normal;
    margin-bottom: 5px
}

.jas-sale-pop h3 {
    margin: 0;
    font-size: 1em;
    max-width: 255px;
    font-weight: 700
}

.jas-sale-pop h3 a {
    color: #000;
    margin: 0;
    font-size: 1em
}

.jas-sale-pop h3:hover a {
    color: #06273c
}

.jas-sale-pop .jas-sale-pop-timeago {
    color: #878787;
    font-size: .85714em
}

.jas-sale-pop .pe-7s-close {
    right: 5px;
    top: 0px;
    cursor: pointer;
    position: absolute;
    font-family: FontAwesome
}

.jas-sale-pop .pe-7s-close:before {
    content: "\f00d"
}

.jas-sale-pop.slideUp {
    opacity: 1;
    visibility: visible
}

</style>
<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    myIndex++;
    if (myIndex > x.length) {
        myIndex = 1
    }
    x[myIndex - 1].style.display = "block";
    setTimeout(carousel, 9000);
}
</script>
<?php
overall_footer();
?>
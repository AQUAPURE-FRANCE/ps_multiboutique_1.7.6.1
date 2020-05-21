// Change strings here
DOMStrings = {
    nav_id: 'js-nav-blog-container',
    section_id: 'js-blog-section',
    url: window.location.protocol + '//' + window.location.host,
    urlPost:  window.location.protocol + '//' + window.location.host + '/smartblog/',
    urlImg:  window.location.protocol + '//' + window.location.host + '/modules/smartblog/images/',
    imgTemp: window.location.protocol + '//' + window.location.host + '/img/cms/photodune-1643290-water-drop-m.jpg',
    userLang: navigator.language || navigator.userLanguage
};

const getNavTemplate = (latestPosts, isHighlighted) => {
    var templateNav = `
        <!-- Display on min-width: 992px -->
        <div class="d-md-block d-lg-none col-md-12">
            <div class="col-md-12">
                <a href="${isHighlighted.url}">
                    <img src="${isHighlighted.img || 'http://3.1.aquapure.fr/img/cms/photodune-1643290-water-drop-m.jpg'}">
                </a>
            </div>
            <div class="mt-4 col-md-12 d-flex flex-column dark-bg">
                <div class="cont-blog">
                    <h2>${isHighlighted.title}</h2>
                    <p>${isHighlighted.text}</p>
                </div>    
            </div>
        </div>
    
        <!-- Display on max-width: 991px -->
        <div class="main-img col-md-4 d-md-none d-lg-block">
            <a href="${isHighlighted.url}">
                <img src="${isHighlighted.img || 'http://3.1.aquapure.fr/img/cms/photodune-1643290-water-drop-m.jpg'}">
            </a>
        </div>
    
        <div class="mt-4 col-md-4 d-md-none d-lg-block d-flex flex-column dark-bg">
            <div class="cont-blog">
                 <h2>${isHighlighted.title}</h2>
                 <p>${isHighlighted.text.substring(0, 350) || ''}</p>
            </div>
        </div>
    
        <div class="articles mt-4 col-md-4 col-lg-4 d-flex flex-column justify-content-center">
            ${latestPosts}
        </div>`;
    return templateNav;
};

const displayLastThreePosts = (container, DOMstrings) => {
    fetch(latestpost_ajax).then((response) => response.json()).then((posts) => {
        var isHighlighted, navTemplate, sectionTemplate, textLong = 60, metaDescription, output = '';
        isHighlighted = {
            img: DOMstrings.urlImg + posts.mostViewed[0].id_smart_blog_post + '-single-default.jpg',
            title: posts.mostViewed[0].meta_title || posts.mostViewed[1].meta_title,
            text: posts.mostViewed[0].short_description || posts.mostViewed[1].short_description,
            url: DOMstrings.urlPost + posts.mostViewed[0].id_smart_blog_post + '_' + posts.mostViewed.link_rewrite + '.html' ||
                DOMstrings.urlPost + posts.mostViewed[1].id_smart_blog_post + '_' + posts.mostViewed.link_rewrite + '.html'
        };

        posts.latest.forEach((post, index) => {
            // Create a string of 60 characters
            if (post.short_description) {
                metaDescription = post.short_description.substring(0, textLong);
            }
            // Create post's url
            var urlPost = DOMstrings.urlPost + post.id_smart_blog_post + '_' + post.link_rewrite + '.html';

            navTemplate =
                        `<div class="row justify-content-center">
                            <a class="row col-md-12" href="${urlPost}" target="_blank">
                                <img class="col-xs-3 col-md-4" width="100"
                                    src="${DOMstrings.urlImg + post.id_smart_blog_post + '-single-default.jpg' || DOMstrings.imgTemp}"
                                    alt="${post.meta_title}"
                                >
                                <span class="col-xs-7 col-md-8 pl-0 pr-0">${metaDescription || ''}...</span>
                            </a>
                        </div>
            `;
            output += navTemplate;
        });
        container.insertAdjacentHTML('beforeend', getNavTemplate(output, isHighlighted));
    })
        .catch((error) => console.log(error));
};

const displayPostsOnBlogSection = (container, DOMstrings) => {
    fetch(latestpost_ajax).then((response) => response.json()).then((posts) => {
        var navTemplate, sectionTemplate, textLong = 60, metaDescription;

        // Create a string of 60 characters
        metaDescripViewed = (posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
            posts.mostViewed[0].short_description.substring(0, textLong + 25) : posts.mostViewed[1].short_description.substring(0, textLong + 25));
        if (posts.lastCommented.short_description) metaDescripLastCommented = posts.lastCommented.short_description.substring(0, textLong + 25);
        if (posts.mostCommented.short_description) metaDescripMostCommented = posts.mostCommented.short_description.substring(0, textLong + 25);

        sectionTemplate = `
		<!-- Most Viewed-->
        <div class="blog-item small-img pb-0 clearfix">
			<!-- Blog Image-->
			<div class="blog-media-home">
				<div class="pic"><img src="${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
		                    DOMstrings.urlImg + posts.mostViewed[0].id_smart_blog_post + '-single-default.jpg' :
		                    DOMstrings.urlImg + posts.mostViewed[1].id_smart_blog_post + '-single-default.jpg'}" alt="${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ? 
		                    posts.mostViewed[0].meta_title : posts.mostViewed[1].meta_title}">
					<div class="hover-effect"></div>
					<div class="links">
						<a href="${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
            DOMstrings.urlImg + posts.mostViewed[0].id_smart_blog_post + '-single-default.jpg' :
            DOMstrings.urlImg + posts.mostViewed[1].id_smart_blog_post + '-single-default.jpg'}" class="link-icon fa fa-image fancy"></a>
						<a target="_blank" href="${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
		                DOMstrings.urlPost + posts.mostViewed[0].id_smart_blog_post + '_' + posts.mostViewed[0].link_rewrite + '.html' :
		                DOMstrings.urlPost + posts.mostViewed[1].id_smart_blog_post + '_' + posts.mostViewed[1].link_rewrite + '.html'}" class="link-icon fa fa-glasses"></a>
					</div>
				</div>
			</div>
			<!-- title, author...-->
			<div class="blog-item-data">
				<div class="blog-date">
					<div class="date">
						<div class="date-cont">
							<span class="day">${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
		                            new Date(posts.mostViewed[0].created).toLocaleDateString('default', {day:'2-digit'}) :
		                            new Date(posts.mostViewed[1].created).toLocaleDateString('default', {day:'2-digit'})}</span>
							<span class="month"><span>${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
		                            new Date(posts.mostViewed[0].created).toLocaleDateString('default', {month:'short'}) :
		                            new Date(posts.mostViewed[1].created).toLocaleDateString('default', {month:'short'})}</span></span>
							<span class="year">${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
		                            new Date(posts.mostViewed[0].created).toLocaleDateString('default', {year:'numeric'}) :
		                            new Date(posts.mostViewed[1].created).toLocaleDateString('default', {year:'numeric'})}</span>
							<i class="springs"></i>
						</div>
					</div>
				</div>
				<h2 class="blog-title"><a target="_blank" href="${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
		                DOMstrings.urlPost + posts.mostViewed[0].id_smart_blog_post + '_' + posts.mostViewed[0].link_rewrite + '.html' :
		                DOMstrings.urlPost + posts.mostViewed[1].id_smart_blog_post + '_' + posts.mostViewed[1].link_rewrite + '.html'}">${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ? 
		                    posts.mostViewed[0].meta_title : posts.mostViewed[1].meta_title}</a></h2>
				<div class="divider gray"></div>
				<p class="post-info">
					by <span class="posr-author">${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ? 
		                    posts.mostViewed[0].firstname : posts.mostViewed[1].firstname} ${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ? 
		                    posts.mostViewed[0].lastname : posts.mostViewed[1].lastname} </span><i>|
					</i><em class="fa fa-eye"></em> ${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ? 
		                    posts.mostViewed[0].viewed : posts.mostViewed[1].viewed}<i>|
					</i><em class="fa fa-comments"></em> ${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ? 
		                    posts.mostViewed[0].comment_num : posts.mostViewed[1].comment_num}
				</p>
			</div>
			<!-- Text Intro-->
			<div class="blog-item-body clearfix">
				<p>${metaDescripViewed}...</p>
			</div>
			<!-- Read More <em class="fa fa-chevron-right"></em> and social links-->
			<div class="blog-item-foot clearfix">
				<a target="_blank" href="${posts.mostViewed[0].id_smart_blog_post !== posts.mostCommented.id_smart_blog_post ?
        DOMstrings.urlPost + posts.mostViewed[0].id_smart_blog_post + '_' + posts.mostViewed[0].link_rewrite + '.html' :
        DOMstrings.urlPost + posts.mostViewed[1].id_smart_blog_post + '_' + posts.mostViewed[1].link_rewrite + '.html'}" class="link pull-right">Read More <em class="fa fa-chevron-right"></em></a>
			</div>
		</div>
		<!-- End Most Viewed-->
		<!-- Most Commented-->
        <div class="blog-item small-img pb-0 clearfix">
			<!-- Blog Image-->
			<div class="blog-media-home">
				<div class="pic"><img src="${DOMstrings.urlImg + posts.lastCommented.id_smart_blog_post + '-single-default.jpg' || DOMstrings.imgTemp}" alt="${posts.lastCommented.meta_title}">
					<div class="hover-effect"></div>
					<div class="links">
						<a href="${DOMstrings.urlImg + posts.lastCommented.id_smart_blog_post + '-single-default.jpg' || DOMstrings.imgTemp}" class="link-icon fa fa-image fancy"></a>
						<a target="_blank" href="${DOMstrings.urlPost + posts.lastCommented.id_smart_blog_post + '_' + posts.lastCommented.link_rewrite + '.html'}" class="link-icon fa fa-glasses"></a>
					</div>
				</div>
			</div>
			<!-- title, author...-->
			<div class="blog-item-data">
				<div class="blog-date">
					<div class="date">
						<div class="date-cont">
							<span class="day">${new Date(posts.lastCommented.created).toLocaleDateString('default', {day:'2-digit'})}</span>
							<span class="month"><span>${new Date(posts.lastCommented.created).toLocaleDateString('default', {month:'short'})}</span></span>
							<span class="year">${new Date(posts.lastCommented.created).toLocaleDateString('default', {year:'numeric'})}</span>
							<i class="springs"></i>
						</div>
					</div>
				</div>
				<h2 class="blog-title"><a target="_blank" href="${DOMstrings.urlPost + posts.lastCommented.id_smart_blog_post + '_' + posts.lastCommented.link_rewrite + '.html'}">${posts.lastCommented.meta_title}</a></h2>
				<div class="divider gray"></div>
				<p class="post-info">
					by <span class="posr-author">${posts.lastCommented.firstname} ${posts.lastCommented.lastname} </span><i>|
					</i><em class="fa fa-eye"></em> ${parseInt(posts.lastCommented.viewed)}<i>|
					</i><em class="fa fa-comments"></em> ${parseInt(posts.lastCommented.comment_num)}
				</p>
			</div>
			<!-- Text Intro-->
			<div class="blog-item-body clearfix">
				<p>${metaDescripLastCommented}...</p>
			</div>
			<!-- Read More <em class="fa fa-chevron-right"></em> and social links-->
			<div class="blog-item-foot clearfix">
				<a target="_blank" href="${DOMstrings.urlPost + posts.lastCommented.id_smart_blog_post + '_' + posts.lastCommented.link_rewrite + '.html'}" class="link pull-right">Read More <em class="fa fa-chevron-right"></em></a>
			</div>
		</div>
		<!-- End Most Commented-->				
		<!-- Last Commented-->
        <div class="blog-item small-img pb-0 clearfix">
			<!-- Blog Image-->
			<div class="blog-media-home">
				<div class="pic"><img src="${DOMstrings.urlImg + posts.mostCommented.id_smart_blog_post + '-single-default.jpg' || DOMstrings.imgTemp}" alt="${posts.mostCommented.meta_title}">
					<div class="hover-effect"></div>
					<div class="links">
						<a href="${DOMstrings.urlImg + posts.mostCommented.id_smart_blog_post + '-single-default.jpg' || DOMstrings.imgTemp}" class="link-icon fa fa-image fancy"></a>
						<a target="_blank" href="${DOMstrings.urlPost + posts.mostCommented.id_smart_blog_post + '_' + posts.mostCommented.link_rewrite + '.html'}" class="link-icon fa fa-glasses"></a>
					</div>
				</div>
			</div>
			<!-- title, author...-->
			<div class="blog-item-data">
				<div class="blog-date">
					<div class="date">
						<div class="date-cont">
							<span class="day">${new Date(posts.mostCommented.created).toLocaleDateString('default', {day:'2-digit'})}</span>
							<span class="month"><span>${new Date(posts.mostCommented.created).toLocaleDateString('default', {month:'short'})}</span></span>
							<span class="year">${new Date(posts.mostCommented.created).toLocaleDateString('default', {year:'numeric'})}</span>
							<i class="springs"></i>
						</div>
					</div>
				</div>
				<h2 class="blog-title"><a target="_blank" href="${DOMstrings.urlPost + posts.mostCommented.id_smart_blog_post + '_' + posts.mostCommented.link_rewrite + '.html'}">${posts.mostCommented.meta_title}</a></h2>
				<div class="divider gray"></div>
				<p class="post-info">
					by <span class="posr-author">${posts.mostCommented.firstname} ${posts.mostCommented.lastname} </span><i>|
					</i><em class="fa fa-eye"></em> ${parseInt(posts.mostCommented.viewed)}<i>|
					</i><em class="fa fa-comments"></em> ${parseInt(posts.mostCommented.comment_num)}
				</p>
			</div>
			<!-- Text Intro-->
			<div class="blog-item-body clearfix">
				<p>${metaDescripMostCommented}...</p>
			</div>
			<!-- Read More <em class="fa fa-chevron-right"></em> and social links-->
			<div class="blog-item-foot clearfix">
				<a target="_blank" href="${DOMstrings.urlPost + posts.mostCommented.id_smart_blog_post + '_' + posts.mostCommented.link_rewrite + '.html'}" class="link pull-right">Read More <em class="fa fa-chevron-right"></em></a>
			</div>
		</div>
		<!-- End Last Commented-->`;

        container.innerHTML = sectionTemplate;
    })
        .catch((error) => console.log(error));
};

/** Function called in all pages along website **/
displayLastThreePosts(document.getElementById(DOMStrings.nav_id), DOMStrings);

/** Function called only in homepage **/
if (document.getElementById('index')) {
    // Load most viewed, commented and last commented post on blog section
    displayPostsOnBlogSection(document.getElementById(DOMStrings.section_id), DOMStrings);
}

// Change ul parent's padding to 0
document.getElementById(DOMStrings.nav_id).closest('ul').style.padding = 0;


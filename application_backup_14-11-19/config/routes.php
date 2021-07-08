	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//////////////////////////////////////////////////Admin Panel Start///////////////////////////////////////
$route['admin'] = "admin/login";
$route['admin-forgot-password'] = "admin/login/forgotPassword";
$route['admin-logout'] = "admin/login/logout";
$route['admin-dashboard'] = "admin/dashboard";
$route['admin-profile'] = "admin/admin/updateProfile";
$route['admin-update-profile'] = "admin/admin/adminUpdateProfile";
$route['admin-remove-profile-image'] = "admin/admin/adminRemoveProfilePhoto";

//common
$route['change-country-get-state'] = "common/Common/changeCountryGetState";
$route['change-state-get-city'] = "common/Common/changeStateGetCity";
//common

//Users
$route['admin-manage-users'] = "admin/Users";
$route['admin-manage-user-ajax'] = "admin/Users/manageUsers";
$route['admin-change-user-status'] = "admin/Users/changeStatus";
$route['admin-delete-user'] = "admin/Users/deleteUser";
$route['admin-add-user'] = "admin/Users/addUpdateUser";
$route['admin-update-user/(:num)'] = "admin/Users/addUpdateUser/$1";
$route['admin-add-update-user'] = "admin/Users/saveUser";
$route['admin-delete-user-image'] = "admin/Users/deleteUserImage";
$route['admin-view-user/(:num)'] = "admin/Users/viewUser/$1";
$route['admin-send-customer-notification'] = "admin/Users/sendNotification";
$route['admin-manage-subscribers'] = "admin/Users/subscribersList";
$route['admin-manage-subscribers-ajax'] = "admin/Users/manageSubscribers";
$route['admin-delete-subscribers'] = "admin/Users/deleteSubscribers";





//User Addresses
$route['admin-manage-user-addresses/(:num)'] = "admin/Users/addressList/$1";
$route['admin-manage-user-addresses'] = "admin/Users/addressList";
$route['admin-manage-user-address-ajax'] = "admin/Users/manageUsersAddress";
$route['admin-get-user-address'] = "admin/Users/addressData";
$route['admin-change-user-address-status'] = "admin/Users/changeAddressStatus";
$route['admin-update-user-address/(:num)'] = "admin/Users/userUpdateAddress/$1";
$route['admin-add-user-address/(:num)'] = "admin/Users/userAddAddress/$1";
$route['admin-add-update-user-address'] = "admin/Users/saveUserAddress";
$route['admin-view-user-address/(:num)'] = "admin/Users/viewUserAddress/$1";
$route['admin-delete-user-address'] = "admin/Users/deleteUserAddress";

 /// Service Category
 $route['admin-manage-service-categories'] = "admin/Users/manageServiceCategories";
 $route['admin-manage-service-category-ajax'] = "admin/Users/manageServiceCategoriesAjax";
 $route['admin-change-service-category-status'] = "admin/Users/changeServiceCategoryStatus";
 $route['admin-view-service-category/(:num)'] = "admin/Users/viewServiceCategory/$1";
 $route['admin-add-service-category'] = "admin/Users/addUpdateServiceCategory";
 $route['admin-update-service-category/(:num)'] = "admin/Users/addUpdateServiceCategory/$1";
 $route['admin-add-update-service-category'] = "admin/Users/saveServiceCategory";
 $route['admin-manage-services'] = "admin/Users/manageServiceProviderServices";
 $route['admin-manage-service-ajax'] = "admin/Users/manageServiceProviderServicesAjax";
 $route['admin-view-service/(:num)'] = "admin/Users/viewService/$1";
 $route['admin-change-service-status'] = "admin/Users/changeServiceStatus";
 $route['admin-delete-service'] = "admin/Users/deleteService";
 $route['admin-delete-service-category'] = "admin/Users/deleteServiceCategory";
 $route['admin-add-service'] = "admin/Users/addUpdateService";
 $route['admin-update-service/(:num)'] = "admin/Users/addUpdateService/$1";
 $route['admin-add-update-service'] = "admin/Users/saveService";
 $route['admin-delete-service-image'] = "admin/Users/deleteServiceImage";

 

 

//Pages 
$route['admin-manage-pages'] = "admin/Page";
$route['admin-manage-page-ajax'] = "admin/Page/managePages";
$route['admin-change-page-status'] = "admin/Page/changeStatus";
$route['admin-delete-page'] = "admin/Page/deletepage";
$route['admin-add-page'] = "admin/Page/addUpdatePage";
$route['admin-update-page/(:num)'] = "admin/Page/addUpdatePage/$1";
$route['admin-add-update-page'] = "admin/Page/savepage";
$route['admin-view-page/(:num)'] = "admin/Page/viewPage/$1";
$route['admin-delete-page-image'] = "admin/Page/deletePageImage";
$route['admin-delete-page-banner-image'] = "admin/Page/deletePageBannerImage";

//Website Settings
$route['admin-website-settings'] = "admin/Page/websiteSettings";
$route['admin-update-website-settings'] = "admin/Page/updateWebsiteSettings";
$route['admin-remove-website-logo'] = "admin/Page/removeWebsiteLogo";

//Email Temlates
$route['admin-manage-email-templates'] = "admin/Page/manageEmailTemplates";
$route['admin-manage-email-templates-ajax'] = "admin/Page/manageEmailTemplatesAjax";
//$route['admin-change-team-status'] = "admin/Page/changeStatus";
//$route['admin-delete-team'] = "admin/Page/deleteTeam";
$route['admin-add-email-template'] = "admin/Page/addUpdateEmailTemplate";
$route['admin-update-email-template/(:num)'] = "admin/Page/addUpdateEmailTemplate/$1";
$route['admin-add-update-email-template'] = "admin/Page/saveEmailTemplate";
$route['admin-delete-email-template-banner-image'] = "admin/Page/deleteEmailTemplateBannerImage";
$route['admin-view-email-template/(:num)'] = "admin/Page/viewEmailTemplate/$1";

//Calculations
$route['admin-manage-calculations'] = "admin/Page/manageCalculations";
$route['admin-manage-calculations-ajax'] = "admin/Page/manageCalculationAjax";
$route['admin-change-calculation-status'] = "admin/Page/changeCalculationStatus";
$route['admin-delete-calculation'] = "admin/Page/deleteCalculation";
$route['admin-add-calculation'] = "admin/Page/addUpdateCalculation";
$route['admin-update-calculation/(:num)'] = "admin/Page/addUpdateCalculation/$1";
$route['admin-add-update-calculation'] = "admin/Page/saveCalculation";
$route['admin-view-calculation/(:num)'] = "admin/Page/viewCalculation/$1";
$route['admin-delete-calculation-image'] = "admin/Page/deleteCalculationImage";


////////////student////////////////

$route['admin-manage-student'] = "admin/student/managestudent";
$route['admin-manage-student-ajax'] = "admin/student/managestudentAjax";
$route['admin-change-student-status'] = "admin/student/changestudentStatus";
$route['admin-delete-student'] = "admin/student/deletestudent";
$route['admin-add-student'] = "admin/student/addUpdatestudent";
$route['admin-update-student/(:num)'] = "admin/student/addUpdatestudent/$1";
$route['admin-update-student/(:num)'] = "admin/student/addUpdatestudent/$1";
$route['admin-add-update-student'] = "admin/student/savestudent";
$route['admin-view-student/(:num)'] = "admin/student/viewstudent/$1";
$route['admin-delete-student-image'] = "admin/student/deletestudentImage";

 
//Category
$route['admin-manage-category'] = "admin/Category";
$route['admin-manage-category-ajax'] = "admin/Category/manageCategories";
$route['admin-change-category-status'] = "admin/Category/changeStatus";
$route['admin-delete-category'] = "admin/Category/deleteCategory";
$route['admin-add-category'] = "admin/Category/addUpdateCategory";
$route['admin-update-category/(:num)'] = "admin/Category/addUpdateCategory/$1";
$route['admin-add-update-category'] = "admin/Category/saveCategory";
$route['admin-delete-category-image'] = "admin/Category/deleteCategoryImage";
$route['admin-view-category/(:num)'] = "admin/Category/viewCategory/$1";
$route['admin-category-hierarchy'] = "admin/Category/categoryHierarchy";
$route['admin-get-category-level'] = "admin/Category/categoryLevel";
$route['admin-get-parent-category'] = "admin/Category/categoryParentDom";

//Brand
$route['admin-manage-brand'] = "admin/Brand";
$route['admin-manage-brand-ajax'] = "admin/Brand/manageBrands";
$route['admin-change-brand-status'] = "admin/Brand/changeStatus";
$route['admin-delete-brand'] = "admin/Brand/deleteBrand";
$route['admin-add-brand'] = "admin/Brand/addUpdateBrand";
$route['admin-update-brand/(:num)'] = "admin/Brand/addUpdateBrand/$1";
$route['admin-add-update-brand'] = "admin/Brand/saveBrand";
$route['admin-delete-brand-image'] = "admin/Brand/deleteBrandImage";
$route['admin-view-brand/(:num)'] = "admin/Brand/viewBrand/$1";



//Slider
$route['admin-manage-sliders'] = "admin/Slider";
$route['admin-manage-slider-ajax'] = "admin/Slider/manageSliders";
$route['admin-change-slider-status'] = "admin/Slider/changeStatus";
$route['admin-delete-slider'] = "admin/Slider/deleteSlider";
$route['admin-add-slider'] = "admin/Slider/addUpdateSlider";
$route['admin-update-slider/(:num)'] = "admin/Slider/addUpdateSlider/$1";
$route['admin-add-update-slider'] = "admin/Slider/saveSlider";
$route['admin-delete-slider-image'] = "admin/Slider/deleteSliderImage";
$route['admin-view-slider/(:num)'] = "admin/Slider/viewSlider/$1";


//Our Team
$route['admin-manage-teams'] = "admin/Team";
$route['admin-manage-team-ajax'] = "admin/Team/manageTeam";
$route['admin-change-team-status'] = "admin/Team/changeStatus";
$route['admin-delete-team'] = "admin/Team/deleteTeam";
$route['admin-add-team'] = "admin/Team/addUpdateTeam";
$route['admin-update-team/(:num)'] = "admin/Team/addUpdateTeam/$1";
$route['admin-add-update-team'] = "admin/Team/saveTeam";
$route['admin-delete-team-image'] = "admin/Team/deleteTeamImage";
$route['admin-view-team/(:num)'] = "admin/Team/viewTeam/$1";




//Work Process
$route['admin-manage-work-process'] = "admin/Team/workProcess";
$route['admin-manage-work-process-ajax'] = "admin/Team/manageWorkProcess";
$route['admin-change-work-process-status'] = "admin/Team/changeWorkProcessStatus";
$route['admin-delete-work-process'] = "admin/Team/deleteWorkProcess";
$route['admin-add-work-process'] = "admin/Team/addUpdateWorkProcess";
$route['admin-update-work-process/(:num)'] = "admin/Team/addUpdateWorkProcess/$1";
$route['admin-add-update-work-process'] = "admin/Team/saveWorkProcess";
$route['admin-delete-work-process-image'] = "admin/Team/deleteWorkProcessImage";
$route['admin-view-work-process/(:num)'] = "admin/Team/viewWorkProcess/$1";


//Facilities

$route['admin-manage-facilities'] = "admin/Team/facilities";
$route['admin-manage-facilities-ajax'] = "admin/Team/manageFacilitiesAjax";
$route['admin-change-facility-status'] = "admin/Team/changeFacilityStatus";
$route['admin-delete-facility'] = "admin/Team/deleteFacility";
$route['admin-add-facility'] = "admin/Team/addUpdateFacility";
$route['admin-update-facility/(:num)'] = "admin/Team/addUpdateFacility/$1";
$route['admin-add-update-facility'] = "admin/Team/saveFacility";
$route['admin-delete-facility-image'] = "admin/Team/deleteFacilityImage";
$route['admin-view-facility/(:num)'] = "admin/Team/viewFacility/$1";




//Our Services
$route['admin-manage-our-services'] = "admin/Team/ourServices";
$route['admin-manage-our-services-ajax'] = "admin/Team/manageOurServicesAjax";
$route['admin-change-our-services-status'] = "admin/Team/changeOurServiceStatus";
$route['admin-delete-our-services'] = "admin/Team/deleteOurService";
$route['admin-add-our-service'] = "admin/Team/addUpdateOurServices";
$route['admin-update-our-service/(:num)'] = "admin/Team/addUpdateOurServices/$1";
$route['admin-add-update-our-service'] = "admin/Team/saveOurServices";
$route['admin-delete-our-services-image'] = "admin/Team/deleteOurServiceImage";
$route['admin-view-our-service/(:num)'] = "admin/Team/viewOurService/$1";


//Faq
$route['admin-manage-faqs'] = "admin/Slider/faqList";
$route['admin-manage-faq-ajax'] = "admin/Slider/manageFaqs";
$route['admin-change-faq-status'] = "admin/Slider/changeFaqStatus";
$route['admin-delete-faq'] = "admin/Slider/deleteFaq";
$route['admin-add-faq'] = "admin/Slider/addUpdateFaq";
$route['admin-update-faq/(:num)'] = "admin/Slider/addUpdateFaq/$1";
$route['admin-add-update-faq'] = "admin/Slider/saveFaq";
$route['admin-view-faq/(:num)'] = "admin/Slider/viewFaq/$1";

//Review
$route['admin-manage-reviews'] = "admin/Review";
$route['admin-manage-review-ajax'] = "admin/Review/manageReviews";
$route['admin-change-review-status'] = "admin/Review/changeReviewStatus";
$route['admin-delete-review'] = "admin/Review/deleteReview";
$route['admin-change-rating'] = "admin/Review/changeRating";
$route['admin-update-rating'] = "admin/Review/updateRating";

//Contact US

$route['admin-manage-contact-us'] = "admin/Review/contactUs";
$route['admin-manage-contact-us-ajax'] = "admin/Review/managecontactUs";
$route['admin-change-contact-status'] = "admin/Review/changeContactUSStatus";
$route['admin-delete-contact-us'] = "admin/Review/deleteContactUs";
 

//Units
$route['admin-manage-unit'] = "admin/Brand/units";
$route['admin-manage-unit-ajax'] = "admin/Brand/manageUnits";
$route['admin-change-unit-status'] = "admin/Brand/changeUnitStatus";
$route['admin-delete-unit'] = "admin/Brand/deleteUnit";
$route['admin-add-unit'] = "admin/Brand/addUpdateUnit";
$route['admin-update-unit/(:num)'] = "admin/Brand/addUpdateUnit/$1";
$route['admin-add-update-unit'] = "admin/Brand/saveUnit";
$route['admin-view-unit/(:num)'] = "admin/Brand/viewUnit/$1";

 //Products
$route['admin-manage-products'] = "admin/Products";
$route['admin-manage-product-ajax'] = "admin/Products/manageProducts";
$route['admin-change-product-status'] = "admin/Products/changeProductStatus";
$route['admin-delete-product'] = "admin/Products/deleteProduct";
$route['admin-add-product'] = "admin/Products/addUpdateProduct";
$route['admin-update-product/(:num)'] = "admin/Products/addUpdateProduct/$1";
$route['admin-add-update-product'] = "admin/Products/saveProduct";
$route['admin-delete-product-image'] = "admin/Products/deleteProductImage";
$route['admin-delete-product-secondary-image'] = "admin/Products/deleteProductSecondaryImage";
$route['admin-view-product/(:num)'] = "admin/Products/viewProduct/$1";
$route['admin-copy-product/(:num)'] = "admin/Products/addCopyProduct/$1";
$route['admin-copy-save-product'] = "admin/Products/copySaveProduct";



$route['admin-manage-master-products'] = "admin/Products/manageMasterProducts";
$route['admin-manage-master-product-ajax'] = "admin/Products/manageMasterProductsAjax";
$route['admin-change-master-product-status'] = "admin/Products/changeMasterProductStatus";
//$route['admin-delete-product'] = "admin/Products/deleteProduct";
$route['admin-add-master-product'] = "admin/Products/addUpdateMasterProduct";
$route['admin-update-master-product/(:num)'] = "admin/Products/addUpdateMasterProduct/$1";
$route['admin-add-update-master-product'] = "admin/Products/saveMasterProduct";
//$route['admin-delete-product-image'] = "admin/Products/deleteProductImage";
//$route['admin-delete-product-secondary-image'] = "admin/Products/deleteProductSecondaryImage";
$route['admin-view-master-product/(:num)'] = "admin/Products/viewMasterProduct/$1";
 //$route['admin-copy-save-product'] = "admin/Products/copySaveProduct";
 





////////Admin Orders/////////////////

$route['admin-manage-orders'] = "admin/Orders";
$route['admin-manage-orders-ajax'] = "admin/Orders/manageOrders";
$route['admin-order-details'] = "admin/Orders/orderDetails";
$route['admin-change-order-status'] = "admin/Orders/changeOrderStatus";
$route['admin-delete-review'] = "admin/Review/deleteReview";
$route['admin-change-rating'] = "admin/Review/changeRating";
$route['admin-update-rating'] = "admin/Review/updateRating";






//////////////////////////////////////////////////Admin Panel End///////////////////////////////////////

//////////////////////////////////////////////////Vendor Panel Start///////////////////////////////////////
$route['vendor'] = "vendor/login";
$route['vendor-forgot-password'] = "vendor/login/forgotPassword";
$route['vendor-logout'] = "vendor/login/logout";
$route['vendor-dashboard'] = "vendor/vendor";
$route['vendor-profile'] = "vendor/vendor/updateProfile";
$route['vendor-update-profile'] = "vendor/vendor/vendorUpdateProfile";
$route['vendor-remove-profile-image'] = "vendor/vendor/vendorRemoveProfilePhoto";
$route['vendor-weather-forecast'] = "vendor/Vendor/weatherForecast";



//Vendor Review
$route['vendor-manage-reviews'] = "vendor/Review";
$route['vendor-manage-review-ajax'] = "vendor/Review/manageReviews";
$route['vendor-change-review-status'] = "vendor/Review/changeReviewStatus";
$route['vendor-delete-review'] = "vendor/Review/deleteReview";
$route['vendor-change-rating'] = "vendor/Review/changeRating";
$route['vendor-update-rating'] = "vendor/Review/updateRating";

/////////// Vendor Products/////////////

$route['vendor-manage-products'] = "vendor/Products";
$route['vendor-manage-product-ajax'] = "vendor/Products/manageProducts";
$route['vendor-manage-products'] = "vendor/Products";
$route['vendor-manage-product-ajax'] = "vendor/Products/manageProducts";
$route['vendor-change-product-status'] = "vendor/Products/changeProductStatus";
$route['vendor-delete-product'] = "vendor/Products/deleteProduct";
$route['vendor-add-product'] = "vendor/Products/addUpdateProduct";
$route['vendor-update-product/(:num)'] = "vendor/Products/addUpdateProduct/$1";
$route['vendor-add-update-product'] = "vendor/Products/saveProduct";
$route['vendor-delete-product-image'] = "vendor/Products/deleteProductImage";
$route['vendor-delete-product-secondary-image'] = "vendor/Products/deleteProductSecondaryImage";
$route['vendor-view-product/(:num)'] = "vendor/Products/viewProduct/$1";
$route['vendor-copy-product/(:num)'] = "vendor/Products/addCopyProduct/$1";
$route['vendor-copy-save-product'] = "vendor/Products/copySaveProduct";


////////////Vendor Customers///////////////////

$route['vendor-manage-customers'] = "vendor/vendor/manageCustomers";
$route['vendor-manage-customer-ajax'] = "vendor/vendor/manageCustomersAjax";
$route['vendor-view-customer'] = "vendor/vendor/manageCustomersAjax";
$route['vendor-view-customer/(:num)'] = "vendor/vendor/viewCustomer/$1";
$route['vendor-manage-customer-addresses/(:num)'] = "vendor/vendor/addressList/$1";
$route['vendor-manage-customer-address-ajax'] = "vendor/vendor/customerAddressListAjax";

 ////////Vendor Orders/////////////////

$route['vendor-manage-orders'] = "vendor/Orders";
$route['vendor-manage-orders-ajax'] = "vendor/Orders/manageOrders";
$route['vendor-order-details'] = "vendor/Orders/orderDetails";
$route['vendor-delete-review'] = "vendor/Review/deleteReview";
$route['vendor-change-rating'] = "vendor/Review/changeRating";
$route['vendor-update-rating'] = "vendor/Review/updateRating";

//////////////////////////////////////////////////Vendor Panel End///////////////////////////////////////



//////////////////Customer Section Start ////////////////
$route['customer-dashboard']='Customer/index';
$route['customer-update-profile']='Customer/fetchProfile';
$route['customer-save-update-profile']='Customer/updateProfile';
$route['customer-manage-addresses']='Customer/manageAddresses';
$route['customer-orders']='Customer/customerOrders';
$route['customer-wishlist']='Customer/customerWishlist';
$route['customer-add-address']='Customer/addAddress';
$route['customer-update-address/(:num)']='Customer/addAddress/$1';
$route['customer-save-address']='Customer/saveAddress';
$route['customer-delete-address'] = "Customer/deleteAddress";
$route['customer-remove-image']='Customer/removeProfilePhoto';


//////////////////Customer Section End ////////////////

//////////////////Delivery Boy Section Start ////////////////
$route['delivery-boy-dashboard']='Deliveryboy/index';
$route['delivery-boy-update-profile']='Deliveryboy/fetchProfile';
$route['delivery-boy-save-update-profile']='Deliveryboy/updateProfile';
$route['delivery-boy-assigned-orders']='Deliveryboy/assignedOrders';

 //////////////////Delivery Boy Section End ////////////////

//////////////////Service Provider Section Start ////////////////
$route['service-provider-dashboard']='Serviceprovider/index';
$route['service-provider-update-profile']='Serviceprovider/fetchProfile';
$route['service-provider-save-update-profile']='Serviceprovider/updateProfile';
$route['service-provider-remove-image']='Serviceprovider/removeProfilePhoto';
$route['service-provider-services']='Serviceprovider/services';
$route['service-provider-add-service']='Serviceprovider/addServices';
$route['service-provider-update-service/(:num)']='Serviceprovider/addServices/$1';
$route['service-provider-save-service'] = "Serviceprovider/saveService";
$route['service-provider-delete-service'] = "Serviceprovider/deleteService";



//////////////////Service Provider Section End ////////////////


////////////////Graphical Representation//////////
$route['admin-manage-graph']="admin/graph";
$route['admin-manage-graph-ajax']="admin/graph/fetch_data";
$route['admin-invoice']="admin/graph/invoice";


////////////Website//////////////////

/////////////////Website Start//////////////////
$route['registration-step-one']='Website/registrationStepOne';
$route['registration-step-two']='Website/registrationStepTwo';
$route['user-registration'] = "Website/addUser";
$route['account-verification'] = "Website/accountVerification";
$route['check-change-password'] = "Website/checkChangePassword";
$route['change-password/(:any)'] = "Website/changePassword/$1";


$route['login']='Website/login';
$route['check-login']='Website/checkLogin';
$route['logout']='Website/logout';
$route['forgot-password']='Website/forgotPassword';
$route['change-language']='Website/changeLanguage';


$route['about-us']='Website/aboutUs';
$route['contact-us']='Website/contactUs';
$route['our-team']='Website/ourTeam';
$route['contact-us-now']='Website/contactUsNow';
$route['subscribe'] = "Website/subscribe";
$route['products'] = "Website/products";
$route['products/(:any)'] = "Website/products/$1";
$route['product-details/(:any)'] = "Website/productDetails/$1";
$route['cart']='Cart/index';
$route['wishlist']='Cart/wishList';
$route['add-remove-wish-list']='Cart/addRemoveWishlist';
$route['add-product-to-cart']='Cart/addProductToCart';






$route['why-us']='Website/whyUs';
$route['faq']='Website/faq';
$route['contact-us']='Website/contactUs';
$route['growers']='Website/growerList';
$route['services'] = "Website/services";
$route['services/(:any)'] = "Website/services/$1";
$route["services/(:any)/(:any)"]="Website/services/$1/$2";

$route['service-details/(:any)'] = "Website/serviceDetails/$1";
$route['rating']='Website/rating';

$route['payment']='CheckOut/payment';
$route['payment-success']='CheckOut/success';
$route['payment-failure']='CheckOut/failure';






$route['default_controller'] = 'website';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

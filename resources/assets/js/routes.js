/**
 * Created by d on 17-2-23.
 */
import {redirectAfterLogin, redirectBeforeLogin} from "./app/Utils";

const routes = [
  {
    path: '/',
    component: require('./components/App.vue'),
    children: [
      {
        path : '',
        component : require('./components/Dashboard.vue')
      },
      {
        path: '/news/info',
        component: require('./components/News/Newsinfo.vue')
      },
      {
        path     : '/news/comment/:id',
        component: require('./components/News/Comment.vue')
      },
      {
        path     : '/news/newsComment/:id',
        component: require('./components/News/NewsComments.vue')
      },
      {
        path: '/adsposition',
        component: require('./components/Ads/AdsPosition.vue')
      },
      {
        path: '/news/flash',
        component: require('./components/News/Newsflash.vue')
      },
      {
        path: '/news/scoop',
        component: require('./components/News/Scoop.vue')
      },
      {
        path: '/news/addScoop',
        component: require('./components/News/AddScoop.vue')
      },
      {
        path: '/news/editScoop/:id',
        component: require('./components/News/EditScoop.vue')
      },
      {
        path       : '/news/scoopCate',
        component  : require('./components/News/ScoopCate.vue')
      },
      {
        path: '/role',
        component: require('./components/Permission/Role.vue')
      },
      {
        path: '/admin',
        component: require('./components/Permission/Admins.vue')
      },
      {
        path : '/currenttrade',
        component : require('./components/Trade/currenttrade.vue')
      },
      {
        path : '/historytrade',
        component : require('./components/Trade/historytrade.vue')
      },
      {
        path : '/totalassets',
        component : require('./components/Assets/totalassets.vue')
      },
      {
        path : '/currentassets',
        component : require('./components/Assets/currentassets.vue')
      },
      {
        path : '/historyassets',
        component : require('./components/Assets/historyassets.vue')
      },
      {
        path : '/onlinestat',
        name:'onlinestat',
        component : require('./components/Reports/Online.vue')
      },
      {
        path : '/registerstat',
        name:'registerstat',
        component : require('./components/Reports/Register.vue')
      },

      {
        path : '/RegisterDetail/:date&:begin&:end',
        name:'regdetail',
        component : require('./components/Reports/RegisterDetail.vue')
      },
      {
        path : '/openstat',
        name:'openstat',
        component : require('./components/Reports/Open.vue')
      },
      {
        path : '/OpenDetail',
        name:'OpenDetail',
        component : require('./components/Reports/OpenDetail.vue')
      },
      {
        path : '/transstat',
        name:'transstat',
        component : require('./components/Reports/Transcation.vue')
      },
      {
        path : '/transstatdetails',
        name:'transstatdetails',
        component : require('./components/Reports/TransDetail.vue')
      },
      {
        path     : '/ads',
        component: require('./components/Ads/Ads.vue'),
      },
      {
        path: '/ads/add',
        component: require('./components/Ads/AddAds.vue'),
      },
      {
        path: '/ads/edit/:id',
        name: 'ads/edit',
        component: require('./components/Ads/EditAds.vue'),
      },
      {
        path: '/resources',
        component: require('./components/Ads/Resources.vue'),
      },
      {
        path: '/resources/add',
        component: require('./components/Ads/AddResources.vue'),
      },
      {
        path: '/resources/edit/:id',
        name: '/resources/edit',
        component: require('./components/Ads/EditResources.vue'),
      },
      {
        path: '/products',
        component: require('./components/Product/Index.vue'),
      },
      {
        path: '/products/add',
        component: require('./components/Product/AddProduct.vue'),
      },
      {
        path: '/products/edit/:id',
        name: '/products/edit',
        component: require('./components/Product/Edit.vue'),
      },
      {
        path: '/disclaimer',
        component: require('./components/Product/Disclaimer.vue'),
      },
      {
        path: '/agreement',
        component: require('./components/Product/Agreement.vue'),
      },
      {
        path: '/agreement/add',
        component: require('./components/Product/AddAgreement.vue'),
      },
      {
        path: '/agreement/edit/:id',
        name: '/agreement/edit',
        component: require('./components/Product/EditAgreement.vue'),
      },
      {
        path: '/sge',
        component: require('./components/Product/Sge.vue'),
      },
      {
        path: '/sge/sgeQuestion/:id',
        name: '/sge/sgeQuestion',
        component: require('./components/Product/SgeQuestion.vue'),
      },
      {
        path: '/notice',
        component: require('./components/Ads/Notice.vue'),
      },
      {
        path: '/notice/add',
        component: require('./components/Ads/AddNotice.vue'),
      },
      {
        path: '/notice/edit/:id',
        name: 'notice/edit',
        component: require('./components/Ads/EditNotice.vue'),
      },
      {
        path: '/leaders',
        component: require('./components/Leaders/Leaders.vue'),
      },
      {
        path: '/leaders/add',
        component: require('./components/Leaders/AddLeaders.vue'),
      },
      {
        path: '/leaders/edit/:id',
        name: 'leaders/edit',
        component: require('./components/Leaders/EditLeaders.vue'),
      },
      {
        path: '/contacts',
        component: require('./components/Contacts/Contacts.vue'),
      },
      {
        path: '/contacts/add',
        component: require('./components/Contacts/AddContacts.vue'),
      },
      {
        path: '/contacts/edit/:id',
        name: 'contacts/edit',
        component: require('./components/Contacts/EditContacts.vue'),
      },
      {
        path: '/recruits',
        component: require('./components/Recruits/Recruits.vue'),
      },
      {
        path: '/recruits/add',
        component: require('./components/Recruits/AddRecruits.vue'),
      },
      {
        path: '/recruits/edit/:id',
        name: 'recruits/edit',
        component: require('./components/Recruits/EditRecruits.vue'),
      },
      {
        path: '/account',
        component: require('./components/Account/Account.vue'),
      },
      {
        path: '/broker',
        component: require('./components/Account/Broker.vue'),
      },
      {
        path: '/branch',
        component: require('./components/Account/Branch.vue'),
      },
      {
        path: '/service',
        component: require('./components/Account/CustomerService.vue'),
      },
      {
        path: '/service/add',
        component: require('./components/Account/AddService.vue'),
      },
      {
        path: '/service/edit/:id',
        name: 'service/edit',
        component: require('./components/Account/EditService.vue'),
      },
      {
        path: '/account/capital/:id',
        name: 'account/capital',
        component: require('./components/Account/Capital.vue'),
      },
      {
        path: '/account/transfers/:id',
        name: 'account/transfers',
        component: require('./components/Account/Transfers.vue'),
      },
      {
        path: '/feedback',
        component: require('./components/Feedback/Feedback.vue'),
      },
      {
        path: '/broker/add',
        component: require('./components/Account/AddBroker.vue'),
      },
      {
        path: '/broker/edit/:id',
        name: 'broker/edit',
        component: require('./components/Account/EditBroker.vue'),
      },
      {
        path: '/product/complaint',
        component: require('./components/Product/Complaint.vue'),
      },
      {
        path: '/version',
        component: require('./components/Version/Version.vue'),
      }
    ],
    beforeEnter: redirectBeforeLogin
  },
  {
    path: '/login',
    component: require('./components/Auth/Login.vue'),
    beforeEnter: redirectAfterLogin
  }
];

export default routes;
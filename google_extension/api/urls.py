from django.urls import path
from . import views

app_name = 'referral_api'

urlpatterns = [
    path('list/customer/<str:search>/template', views.ReferralListByCustomerTemplateView.as_view(),
         name='referral_list_by_customer'),
    path('create/customer/<str:iin>/template', views.ReferralCreateByCustomerTemplateView.as_view(),
         name='referral_create_by_customer'),
    path('perform/<int:pk>/template', views.ReferralPerformTemplateView.as_view(),
         name='referral_perform'),
    path('<int:pk>', views.ReferralDetailView.as_view(),
         name='referral-detail'),
    path('hospital/services', views.HospitalServicesListView.as_view(),
         name='hospital-services'),
    path('index/api', views.IndexView.as_view(),
         name='index_api'),
    path('referrals/', views.ReferralListView.as_view(), name='referral-list')
]

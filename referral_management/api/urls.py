from django.urls import path
from . import views

app_name = 'referral_api'

urlpatterns = [
    path('<int:pk>', views.ReferralDetail.as_view(), name='referral-detail'),
    path('referral/create', views.ReferralCreate.as_view(), name='referral-create'),
    path('referrals/<str:iin>/by_iin', views.ReferralsByIin.as_view(), name='referrals_by_iin'),
    path('referrals/', views.ReferralList.as_view(), name='referral_list'),
    path('referrals/<str:hospital_code>/by_hospital', views.ReferralsByHospital.as_view(),
        name='referral_by_hospital'),
    path('referrals/<int:pk>/update/', views.ReferralUpdateView.as_view(), name='referral-update'),
]

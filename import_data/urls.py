from django.urls import path
from . import views
app_name = 'import_data'
urlpatterns = [
    path('icd/', views.ImportICDView.as_view(), name="mkb10"),
    path('service/', views.ImportServiceView.as_view(), name="service"),
    path('service/django', views.ImportServiceDjangoView.as_view(), name="service_django"),
    path('icd/django', views.ImportICDDjangoView.as_view(), name="icd_django"),


]

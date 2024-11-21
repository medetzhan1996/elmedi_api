from django.urls import path
from . import views

app_name = 'directory_api'

urlpatterns = [
    path('icds/', views.ICDAPIView.as_view()),
    path('services/', views.ServiceAPIView.as_view())
]

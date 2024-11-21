from rest_framework import generics
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from rest_framework import filters
from ..models import ICD, Service
from .serializers import ICDSerializer, ServiceSerializer


class ServiceAPIView(generics.ListAPIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    search_fields = ['title', 'code']
    filter_backends = (filters.SearchFilter,)
    queryset = Service.objects.all()
    serializer_class = ServiceSerializer


class ICDAPIView(generics.ListCreateAPIView):
    authentication_classes = (TokenAuthentication,)
    permission_classes = (IsAuthenticated,)
    search_fields = ['title', 'code']
    filter_backends = (filters.SearchFilter,)
    queryset = ICD.objects.all()
    serializer_class = ICDSerializer

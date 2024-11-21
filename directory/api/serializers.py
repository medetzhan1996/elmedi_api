from rest_framework import serializers
from ..models import ICD, Hospital, Service


# Сериализатор направления
class ServiceSerializer(serializers.ModelSerializer):

    class Meta:
        model = Service
        fields = ['id', 'title', 'code']


# Сериализатор направления
class ICDSerializer(serializers.ModelSerializer):

    class Meta:
        model = ICD
        fields = ['id', 'title', 'code']


class HospitalSerializer(serializers.ModelSerializer):

    class Meta:
        model = Hospital
        fields = ['id', 'title']

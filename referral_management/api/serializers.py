from rest_framework import serializers
from elmedi_api.constants import *
from ..models import Referral
from customer_management.models import Customer, CustomerInsurance
from directory.models import Service, ICD, Hospital


# Сериализатор направления
class ReferralSerializer(serializers.ModelSerializer):
    service = serializers.SlugRelatedField(
        queryset=Service.objects.all(), slug_field='code')
    customer_insurance = serializers.SlugRelatedField(
        queryset=CustomerInsurance.objects.all(), slug_field='card_number')
    icd = serializers.SlugRelatedField(
        queryset=ICD.objects.all(), slug_field='code')
    sending_hospital = serializers.SlugRelatedField(
        queryset=Hospital.objects.all(), slug_field='code')
    directed_hospital = serializers.SlugRelatedField(
        queryset=Hospital.objects.all(), slug_field='code')
    customer = serializers.SlugRelatedField(
        queryset=Customer.objects.all(), slug_field='iin')

    class Meta:
        model = Referral
        fields = [
            'id', 'sending_hospital', 'directed_hospital',
            'service', 'doctor_full_name', 'date',
            'cancel_date', 'customer_insurance', 'icd', 'status',
            'type_appeal', 'place', 'customer', 'time'
        ]


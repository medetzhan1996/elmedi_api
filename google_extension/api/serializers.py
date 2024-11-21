from rest_framework import serializers

from referral_management.models import Referral
from customer_management.models import CustomerInsurance
from directory.models import Service, ICD


# Сериализатор направления
class ReferralSerializer(serializers.ModelSerializer):
    service = serializers.SlugRelatedField(
        queryset=Service.objects.all(), slug_field='code')
    card_number = serializers.SlugRelatedField(
        queryset=CustomerInsurance.objects.all(), slug_field='card_number')
    icd = serializers.SlugRelatedField(
        queryset=ICD.objects.all(), slug_field='code')

    class Meta:
        model = Referral
        fields = [
            'id', 'customer', 'sending_hospital', 'directed_hospital',
            'service', 'doctor_full_name', 'date',
            'cancel_date', 'card_number', 'icd', 'status'
        ]


# Сериализатор направления
class HospitalServicesSerializer(serializers.Serializer):
    services = serializers.SlugRelatedField(
        queryset=Service.objects.all(), slug_field='code', many=True)

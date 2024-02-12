from rest_framework import serializers
from elmedi_api.constants import *
from ..models import Invoice
from customer_management.models import Customer, CustomerInsurance
from directory.models import Service, ICD, Hospital


# Сериализатор направления
class InvoiceSerializer(serializers.ModelSerializer):
    customer = serializers.SlugRelatedField(
        queryset=Customer.objects.all(), slug_field='iin')
    service = serializers.SlugRelatedField(
        queryset=Service.objects.all(), slug_field='code')
    customer_insurance = serializers.SlugRelatedField(
        queryset=CustomerInsurance.objects.all(), slug_field='card_number')
    icd = serializers.SlugRelatedField(
        queryset=ICD.objects.all(), slug_field='code')
    hospital = serializers.SlugRelatedField(
        queryset=Hospital.objects.all(), slug_field='code')

    class Meta:
        model = Invoice
        fields = [
            'id', 'hospital', 'service', 'consumption', 'performing_doctor',
            'type_appeal', 'place', 'customer_insurance', 'icd', 'customer',
            'doctor_signature', 'screen', 'screen_title'
        ]


class PerformedServicesSerializer(serializers.Serializer):
    card_number = serializers.SlugRelatedField(
        queryset=CustomerInsurance.objects.all(), slug_field='card_number')
    hospital = serializers.SlugRelatedField(
        queryset=Hospital.objects.all(), slug_field='code')
    icd = serializers.SlugRelatedField(
        queryset=ICD.objects.all(), slug_field='code')
    type_appeal = serializers.ChoiceField(
        choices=TYPE_APPEAL_CHOICES, allow_blank=True)
    place = serializers.ChoiceField(choices=PLACE_CHOICES)


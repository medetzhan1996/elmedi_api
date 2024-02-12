from rest_framework import serializers
from ..models import Customer, CustomerInsurance
from directory.models import Hospital, ICD, Insurance
from elmedi_api.constants import TYPE_APPEAL_CHOICES, PLACE_CHOICES


# Сериализатор страховки клиента
class CustomerInsuranceSerializer(serializers.ModelSerializer):
    insurance = serializers.SlugRelatedField(
        queryset=Insurance.objects.all(), slug_field='code')
    customer = serializers.SlugRelatedField(
        queryset=Customer.objects.all(), slug_field='iin', write_only=True)

    class Meta:
        model = CustomerInsurance
        fields = ['id', 'insurance', 'card_number', 'begin_date', 'end_date', 'customer',\
                  'limit', 'invoice_sum', 'program', 'insurer', 'pay_type']


# Сериализатор клиента
class CustomerSerializer(serializers.ModelSerializer):
    customer_insurance = CustomerInsuranceSerializer(many=True, read_only=True)

    class Meta:
        model = Customer
        fields = ['id', 'first_name', 'last_name', 'surname', 'iin', 'customer_insurance',\
                  'address', 'place_work', 'telephone_number', 'profession', 'gender',
                  'birthday', 'passport_number', 'address', 'telephone_number']


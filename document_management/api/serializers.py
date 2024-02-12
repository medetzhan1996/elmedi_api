from rest_framework import serializers
from customer_management.models import Customer
from ..models import AttachedDocument


# Сериализатор направления
class AttachedDocumentSerializer(serializers.ModelSerializer):
    customer = serializers.SlugRelatedField(
        queryset=Customer.objects.all(), slug_field='iin', write_only=True)

    class Meta:
        model = AttachedDocument
        fields = ['title', 'file', 'screen', 'customer', 'invoice']

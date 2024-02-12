from rest_framework import serializers
from customer_management.models import CustomerInsurance
from directory.models import Hospital, ICD
from elmedi_api.constants import TYPE_APPEAL_CHOICES, PLACE_CHOICES
from ..models import Doctor, DoctorTimetable


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



# Сериализатор направления
class DoctorTimetableSerializer(serializers.ModelSerializer):
    doctor = serializers.SlugRelatedField(
        queryset=Doctor.objects.all(), slug_field='code')

    class Meta:
        model = DoctorTimetable
        fields = [
            'id', 'doctor', 'date', 'time'
        ]


# Сериализатор направления
class DoctorSerializer(serializers.ModelSerializer):
    hospital = serializers.SlugRelatedField(
        queryset=Hospital.objects.all(), slug_field='code')

    class Meta:
        model = Doctor
        fields = [
            'id', 'first_name', 'last_name', 'surname',
            'hospital', 'code'
        ]




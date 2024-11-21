from django import forms
from .models import Invoice


class InvoiceForm(forms.ModelForm):

    class Meta:
        model = Invoice
        fields = [
            'service', 'icd', 'customer_insurance',
            'referral', 'consumption', 'performing_doctor', 'hospital',
            'type_appeal', 'place', 'doctor_signature', 'screen'
        ]

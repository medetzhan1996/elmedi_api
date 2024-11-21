# Generated by Django 4.0.6 on 2022-07-23 07:53

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('customer_management', '0002_alter_customerinsurance_customer'),
        ('invoice_management', '0001_initial'),
    ]

    operations = [
        migrations.AddField(
            model_name='invoice',
            name='customer',
            field=models.ForeignKey(default=1, on_delete=django.db.models.deletion.CASCADE, to='customer_management.customer'),
            preserve_default=False,
        ),
    ]
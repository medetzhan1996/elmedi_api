# Generated by Django 4.0.6 on 2022-08-10 13:20

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('customer_management', '0006_customerinsurance_insurer_and_more'),
    ]

    operations = [
        migrations.AlterField(
            model_name='customerinsurance',
            name='invoice_sum',
            field=models.CharField(max_length=320),
        ),
        migrations.AlterField(
            model_name='customerinsurance',
            name='limit',
            field=models.CharField(max_length=320),
        ),
    ]

# Generated by Django 4.0.6 on 2022-07-23 09:21

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('customer_management', '0004_alter_customer_address_alter_customer_national_and_more'),
    ]

    operations = [
        migrations.AlterField(
            model_name='customerinsurance',
            name='card_number',
            field=models.CharField(max_length=180, unique=True),
        ),
    ]
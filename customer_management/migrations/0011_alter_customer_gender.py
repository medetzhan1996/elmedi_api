# Generated by Django 4.0.6 on 2023-03-20 09:49

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('customer_management', '0010_alter_customer_gender'),
    ]

    operations = [
        migrations.AlterField(
            model_name='customer',
            name='gender',
            field=models.CharField(blank=True, choices=[('Мужчина', 'Мужчина'), ('Женщина', 'Женщина')], max_length=180, null=True),
        ),
    ]
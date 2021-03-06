<?php
namespace Payum\Core\Bridge\Symfony\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreditCardExpirationDateType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ('choice' == $options['widget']) {
            if (empty($view['day']->vars['value'])) {
                $view['day']->vars['value'] = $view['day']->vars['choices'][0]->value;
            }

            $style = 'display:none';
            if (false == empty($view['day']->vars['attr']['style'])) {
                $style = $view['day']->vars['attr']['style'].'; '.$style;
            }

            $view['day']->vars['attr']['style'] = $style;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'max_expiration_year' => date('Y') + 10,
            'min_expiration_year' => date('Y'),
            'years' => function(Options $options) {
                return range($options['min_expiration_year'], $options['max_expiration_year']);
            },
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'date';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'payum_credit_card_expiration_date';
    }
}

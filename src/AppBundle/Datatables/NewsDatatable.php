<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class NewsDatatable
 *
 * @package AppBundle\Datatables
 */
class NewsDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-3">',
            'end_html'   => '<hr></div></div>',
            'actions'    => array(
                array(
                    'route'      => $this->router->generate('news_new'),
                    'label'      => $this->translator->trans('datatables.actions.new'),
                    'icon'       => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel'   => 'tooltip',
                        'title' => $this->translator->trans('datatables.actions.new'),
                        'class' => 'btn btn-primary',
                        'role'  => 'button'
                    ),
                )
            )
        ));

        $this->features->set(array(
            'auto_width'      => true,
            'defer_render'    => false,
            'info'            => true,
            'jquery_ui'       => false,
            'length_change'   => true,
            'ordering'        => true,
            'paging'          => true,
            'processing'      => true,
            'scroll_x'        => false,
            'scroll_y'        => '',
            'searching'       => true,
            'state_save'      => false,
            'delay'           => 0,
            'extensions'      => array(),
            'highlight'       => false,
            'highlight_color' => 'red'
        ));

        $this->ajax->set(array(
            'url'      => $this->router->generate('news_results'),
            'type'     => 'GET',
            'pipeline' => 0
        ));

        $this->options->set(array(
            'display_start'                 => 0,
            'defer_loading'                 => -1,
            'dom'                           => 'lfrtip',
            'length_menu'                   => array(10, 25, 50, 100),
            'order_classes'                 => true,
            'order'                         => array(array(0, 'asc')),
            'order_multi'                   => true,
            'page_length'                   => 10,
            'paging_type'                   => Style::FULL_NUMBERS_PAGINATION,
            'renderer'                      => '',
            'scroll_collapse'               => false,
            'search_delay'                  => 0,
            'state_duration'                => 7200,
            'stripe_classes'                => array(),
            'class'                         => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering'          => true,
            'individual_filtering_position' => 'head',
            'use_integration_options'       => false,
            'force_dom'                     => false,
            'row_id'                        => 'id'
        ));

        $this->columnBuilder
            ->add('headline', 'column', array(
                'title' => 'Überschrift',
            ))
            ->add('shortDescription', 'column', array(
                'title' => 'Kurz Beschreibung',
            ))
            ->add('msg', 'column', array(
                'title' => 'Text',
            ))

            ->add('isPublished', 'boolean', array(
                'title' => 'Veröffentlicht',
            ))
            ->add(null, 'action', array(
                'title'   => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route'            => 'news_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label'            => $this->translator->trans('datatables.actions.edit'),
                        'icon'             => 'glyphicon glyphicon-edit',
                        'attributes'       => array(
                            'rel'   => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role'  => 'button'
                        ),
                    )
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\News';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'news_datatable';
    }
}

import React from 'react';
import List from '@/layouts/admin/submission-list';
import { Button, ButtonBar } from '@/components/admin/button-bar';
import { __ } from '@/composables/translations';

export default function Submissions({ submissions }) {
  return (
    <List submissions={submissions}>
      <ButtonBar>
        <Button href={route('submissions')}>{__("All")}</Button>
        <Button href={route('submissions', 'pending')}>{__("Pending")}</Button>
      </ButtonBar>
    </List>
  )
}

import React from 'react';
import List from '@/layouts/admin/submission-list';
import { Stripe } from '@/layouts/admin/frame';
import { __ } from '@/composables/translations';

export default function Submissions({ challenge, submissions }) {
  return (
    <List submissions={submissions}>
      <Stripe>{__("submissions_for", { for: <span className="font-bold">{challenge}</span> })}</Stripe>
    </List>
  )
}

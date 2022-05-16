import React from 'react';
import List from '@/layouts/admin/submission-list';

export default function Submissions({ challenge, submissions }) {
  return (
    <List submissions={ submissions }>{ challenge }</List>
  )
}
